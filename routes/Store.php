<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;


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
