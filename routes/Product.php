<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use App\Models\Product;


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
