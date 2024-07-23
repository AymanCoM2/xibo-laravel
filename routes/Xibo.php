<?php

use App\Models\Display;
use App\Models\Layout;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Http;


// ! ==================== Consuming XIBO  ==================== 

Route::get('/get-displays-data', function (Request $request) {
    //! Below is Logic For SYNCING "Displays&&LAyOUTS"+TOken
    /**
     * 1- Get the Token : 
     * TODO : See how to Make it Last Longer 
     */
    $xiboBaseUrl = "http://localhost/api/";
    $response = Http::asForm()->post($xiboBaseUrl . "authorize/access_token", [
        'client_id' => 'e4facebec0df822d59621962d1321606aa0e6ec4',
        'client_secret' => '45cb3b5c8daad46bdac1fd91a2b44d92387d2ff02f17c00a849a8ceef96db9d52870c177d279e562f60c59531f0803b5e107105a41ec4b01691cb0ab2fdcc33d7b25babdffda0f98dddb20eedcdb1801e6f4d19cebd2c22ac4088652da60e39175139225b016edaa48152eb9a9c242f33e135ba08a2638c154feb7cdb1e5c3',
        'grant_type' => 'client_credentials',
    ]);

    if ($response->successful()) {
        $responseData = $response->json();
        $cmsToken = $responseData['access_token']; // & 1 [TOKEN]
        /**
         * 2- Get the Displays and Show them 
         */
        $response = Http::withToken($cmsToken)
            ->get($xiboBaseUrl . "display");
        $displaysArray = $response->json(); // & 2 [DISPLAYS]

        // ! Save them in Table -> Always Syncing With Xibo [ CRON maybe ]
        // ! Any Update For any Screen Will Send request to Xibo 
        // TODO : Make Also Layouts Saved Here For the Selection 
        foreach ($displaysArray as $eachDisplay) {
            $theDisplayid  = $eachDisplay['displayId'];

            $displayObjectExist = Display::where('xiboId', $theDisplayid)->first();

            if ($displayObjectExist) {
                $displayObjectExist->xiboId = $eachDisplay['displayId'];
                $displayObjectExist->isLoggedIn = $eachDisplay['loggedIn'];
                $displayObjectExist->isAuthorized = $eachDisplay['licensed'];
                $displayObjectExist->displayName = $eachDisplay['deviceName'];
                $displayObjectExist->displayLayout = $eachDisplay['defaultLayout'];
                $displayObjectExist->displayLayoutId = $eachDisplay['defaultLayoutId'];
                $displayObjectExist->save();
            } else {
                $displayObject = new Display();
                $displayObject->xiboId = $eachDisplay['displayId'];
                $displayObject->isLoggedIn = $eachDisplay['loggedIn'];
                $displayObject->isAuthorized = $eachDisplay['licensed'];
                $displayObject->displayName = $eachDisplay['deviceName'];
                $displayObject->displayLayout = $eachDisplay['defaultLayout'];
                $displayObject->displayLayoutId = $eachDisplay['defaultLayoutId'];
                $displayObject->save();
            }
        }

        /**
         * 3- Get also the Layouts With you to Assign Displays TO layouts 
         *      - Display Management (Assign Layout , Enable/Disable , )
         * Selection is Only From Published "status" Layouts 
         */
        $responseForLayouts = Http::withToken($cmsToken)
            ->get($xiboBaseUrl . "layout");
        $layoutsArray = $responseForLayouts->json(); // & 3 [LAYOUTS]

        // dd($layoutsArray) ;
        foreach ($layoutsArray as $eachLayout) {
            $layoutXiboId  = $eachLayout['layoutId'];
            $layoutExist = Layout::where('xiboId', $layoutXiboId)->first();
            if ($layoutExist) {
                $layoutExist->xiboId = $eachLayout['layoutId'];
                $layoutExist->publishingStatus = $eachLayout['publishedStatus'];
                $layoutExist->name = $eachLayout['layout'];
                $layoutExist->save();
            } else {
                $layoutObject  = new Layout();
                $layoutObject->xiboId = $eachLayout['layoutId'];
                $layoutObject->publishingStatus = $eachLayout['publishedStatus'];
                $layoutObject->name = $eachLayout['layout'];
                $layoutObject->save();
            }
        }

        $allDisplays  = Display::paginate(5); // ! THIS IS THE ONLY LINE TO BE HERE , ALL ABOVE REMOVED[Sync,channel]
        return view('displays.manage', compact(['allDisplays']));
    } else {
        dd(response()->json(['error' => 'Failed to get access token'], $response->status()));
        return response()->json(['error' => 'Failed to get access token'], $response->status());
    }
})->name('get-displays');


Route::get('/edit-display/{display_id}', function (Request $request) {
    $editedDisplay = Display::findOrFail($request->display_id);
    if ($editedDisplay) {
        return view('displays.edit', compact(['editedDisplay']));
    } else {
        return redirect()->route('get-displays');
    }
})->name('edit-display-get');


Route::post('/edit-display', function (Request $request) {
    $displayObject  = Display::findOrFail($request->edited_display_id);

    if ($displayObject->isAuthorized != $request->authorization) {
        $token = getTokenHelper();
        $xiboBaseUrl = "http://localhost/api/";
        $toggleAuth = Http::withToken($token)
            ->put($xiboBaseUrl . "display/authorise/" . $displayObject->xiboId);
    }

    if ($displayObject->displayLayoutId != $request->layout_id) {
        $token = getTokenHelper();
        $xiboBaseUrl = "http://localhost/api/";
        $changeDefaultLayout = Http::withToken($token)
            ->put(
                $xiboBaseUrl . "display/defaultlayout/" . $displayObject->xiboId,
                [
                    'layoutId' => $request->layout_id
                ]
            );
    }
    return redirect()->route('get-displays');
})->name('edit-display-post');


function getTokenHelper()
{
    $xiboBaseUrl = "http://localhost/api/";
    $response = Http::asForm()->post($xiboBaseUrl . "authorize/access_token", [
        'client_id' => 'e4facebec0df822d59621962d1321606aa0e6ec4',
        'client_secret' => '45cb3b5c8daad46bdac1fd91a2b44d92387d2ff02f17c00a849a8ceef96db9d52870c177d279e562f60c59531f0803b5e107105a41ec4b01691cb0ab2fdcc33d7b25babdffda0f98dddb20eedcdb1801e6f4d19cebd2c22ac4088652da60e39175139225b016edaa48152eb9a9c242f33e135ba08a2638c154feb7cdb1e5c3',
        'grant_type' => 'client_credentials',
    ]);

    if ($response->successful()) {
        $responseData = $response->json();
        $cmsToken = $responseData['access_token']; // & 1 [TOKEN]
        return $cmsToken;
    } else {
        // TODO : Make it Raise Error 404 
        return "Error";
    }
}
