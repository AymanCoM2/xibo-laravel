<?php

use App\Models\Display;
use App\Models\Layout;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Http;


Route::get('/', function () {
    // return view('welcome');
    return view('home-page');
});

Route::get('/home', function () {
    return view('home-page');
})->name('home-page');
// ! ===============  STORE  ==============
Route::get('/create-store', function () {
    return view('stores.create');
})->name('create-store');

Route::post('/create-store', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'store_name' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $store = new Store();
    $store->store_name = $request->store_name;
    $store->screen_id = $request->screen_id;
    $store->assigned_screen = null; // This needs Later Work 
    $store->save();
    return redirect()->route('manage-stores');
})->name('create-store-post');

Route::get('/manage-stores', function () {
    $allStores = Store::paginate(5);
    return view('stores.manage', compact(['allStores']));
})->name('manage-stores');

Route::post('/delete-store', function (Request $request) {
    $storeid = $request->store_id;
    $theDeletedStore = Store::find($storeid);
    if ($theDeletedStore) {
        $theDeletedStore->delete();
    }
    return redirect()->route('manage-stores');
})->name('delete-store');

Route::get('/edit-store/{store_id}', function (Request $request) {
    $editedStore = Store::find($request->store_id);
    if ($editedStore) {
        return view('stores.edit', compact(['editedStore']));
    } else {
        return redirect()->route('manage-stores');
    }
})->name('edit-store');

Route::post('/edit-store/{store_id}', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'store_name' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $store = Store::findOrFail($request->edited_store_id);
    $store->store_name = $request->store_name;
    $store->screen_id = $request->screen_id;
    $store->assigned_screen = null; // This needs Later Work 
    $store->save();
    return redirect()->route('manage-stores');
})->name('edit-store-post');

// ! ==================== PRODUCTS ==================== 
Route::get('/create-product', function () {
    $allStores = Store::all();
    return view('products.create', compact('allStores'));
})->name('create-product');

Route::post('/create-product', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'product_name' => 'required|string',
        'product_sku' => 'required|string',
        'product_quantity' => 'required|numeric',
        'product_store' => 'required|exists:stores,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $productName = $request->product_name;
    $productSku = $request->product_sku;
    $productQuantity = $request->product_quantity;
    $productStoreId = $request->product_store;

    $newProduct = new Product();
    $newProduct->product_name = $productName;
    $newProduct->sku = $productSku;
    $newProduct->quantity = $productQuantity;
    $newProduct->store_id = $productStoreId;
    $newProduct->save();
    return redirect()->route('manage-products');
})->name('create-product-post');

Route::get('/manage-products', function () {
    $allProducts = Product::paginate(5);
    return view('products.manage', compact('allProducts'));
})->name('manage-products');

Route::post('/delete-product', function (Request $request) {
    $productId = $request->product_id;
    $theDeletedProduct = Product::find($productId);
    if ($theDeletedProduct) {
        $theDeletedProduct->delete();
    }
    return redirect()->route('manage-products');
})->name('delete-product');

Route::get('/edit-product/{product_id}', function (Request $request) {
    $editedProduct = Product::find($request->product_id);
    $allStores  = Store::all();
    if ($editedProduct) {
        return view('products.edit', compact(['editedProduct', 'allStores']));
    } else {
        return redirect()->route('manage-products');
    }
})->name('edit-product');

Route::post('/edit-product/{product_id}', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'product_name' => 'required|string',
        'product_sku' => 'required|string',
        'product_quantity' => 'required|numeric',
        'product_store' => 'required|exists:stores,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $productName = $request->product_name;
    $productSku = $request->product_sku;
    $productQuantity = $request->product_quantity;
    $productStoreId = $request->product_store;

    $newProduct = Product::findOrFail($request->edited_product_id);
    $newProduct->product_name = $productName;
    $newProduct->sku = $productSku;
    $newProduct->quantity = $productQuantity;
    $newProduct->store_id = $productStoreId;
    $newProduct->save();
    return redirect()->route('manage-products');
})->name('edit-product-post');
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
                $displayObjectExist->save();
            } else {
                $displayObject = new Display();
                $displayObject->xiboId = $eachDisplay['displayId'];
                $displayObject->isLoggedIn = $eachDisplay['loggedIn'];
                $displayObject->isAuthorized = $eachDisplay['licensed'];
                $displayObject->displayName = $eachDisplay['deviceName'];
                $displayObject->displayLayout = $eachDisplay['defaultLayout'];
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
            $layoutExist = Layout::where($layoutXiboId)->first();
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
