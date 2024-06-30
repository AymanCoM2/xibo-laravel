<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/store/{storeId}', function (Request $request) {
    $theStoreId  = $request->storeId;
    $theStore =  Store::find($theStoreId);
    if ($theStore) {
        $allStoreProducts  = $theStore->products()->get();
        $filteredProducts = $allStoreProducts->map(function ($product) {
            return $product->makeHidden(['created_at', 'updated_at', 'store_id'])->toArray();
        });
        return response()->json($filteredProducts);
    } else {
        return response()->json(['error' => 'Store not found'], 400);
    }
});
