<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use App\Models\Product;

Route::get('/', function () {
    // return view('welcome');
    return view('home-page');

});

Route::get('/home', function () {
    return view('home-page');
})->name('home-page');

// ! =============== From here i will Put the Routes Related to the STORE 

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


// !  Here are the Routes Related to the Products Links 

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
        return view('products.edit', compact(['editedProduct','allStores']));
    } else {
        return redirect()->route('manage-products');
    }
})->name('edit-product');