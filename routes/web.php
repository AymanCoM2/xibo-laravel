<?php

use App\Models\Display;
use App\Models\Invoice;
use App\Models\Layout;
use App\Models\Prize;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Http;



Route::group([], __DIR__ . '/Store.php'); // * Ok 
Route::group([], __DIR__ . '/Product.php'); // * Ok 
Route::group([], __DIR__ . '/Xibo.php'); // * Ok 
// Route::group(['middleware' => ['auth']], __DIR__ . '/approve.php'); // * Ok 

Route::get('/', function () {
    // return view('welcome');
    return view('home-page');
});

Route::get('/home', function () {
    return view('home-page');
})->name('home-page');

//!=========================SPIN && WIN =====================
Route::get('/spin-win-page-p1', function () {
    return view('screenGames.spin-win-p1');
})->name('spin-win-page-p1');


Route::get('/check-invoice/{invoice_number}', function (Request $request) {
    $invoiceRequestNumber = $request->invoice_number;
    $invoiceObject  = Invoice::where('invoiceNumber', $invoiceRequestNumber)->first();
    if (!$invoiceObject) // ! NUll 
    {
        return response()->json(
            [
                'valid' => false,
                'message' => 'Invoice number is Wrong'
            ],
            400
        );
    }

    $prizes  = Prize::where('invoiceNumber', $invoiceRequestNumber)->get();
    // ! HERE ONLY CHECK IF user Exist But NO prize , another Route For Prizes
    if (count($prizes) == 0) {
        return response()->json(
            [
                'valid' => false,
                'message' => $invoiceObject->invoiceUserName . " Does NOT have Prize"
            ],
            400
        );
    }

    return response()->json(
        [
            'valid' => true,
            'message' => "Ok"
        ],
        200
    );
})->name('check_invoice');


Route::post('/spin-win-page-p2', function (Request $request) {
    $invoiceNumber = $request->invoiceNumber;
    $relatedPrizes  = Prize::where('invoiceNumber', $invoiceNumber)->get();
    $data  = [];
    foreach ($relatedPrizes as $prize) {
        $appendedPrize = new stdClass();
        $appendedPrize->label = $prize->prizeName;
        $appendedPrize->value = $prize->id;
        $data[] = $appendedPrize;
    }
    return view('screenGames.spin-win-p2', ['prizeDataJson' => json_encode($data)]);
})->name('spin-win-page-p2');
