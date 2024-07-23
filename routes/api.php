<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Store;


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

// Route::get('/get-prize-list',  function () {
//     $data = [
//         ["label" => "Dell LAPTOP", "value" => 1, "question" => "What CSS property is used for specifying the area between the content and its border?"], // padding
//         ["label" => "IMAC PRO", "value" => 2, "question" => "What CSS property is used for changing the font?"], //font-family
//         ["label" => "SUZUKI", "value" => 3, "question" => "What CSS property is used for changing the color of text?"], //color
//         ["label" => "HONDA", "value" => 4, "question" => "What CSS property is used for changing the boldness of text?"], //font-weight
//         ["label" => "FERRARI", "value" => 5, "question" => "What CSS property is used for changing the size of text?"], //font-size
//         ["label" => "APARTMENT", "value" => 6, "question" => "What CSS property is used for changing the background color of a box?"], //background-color
//         ["label" => "IPAD PRO", "value" => 7, "question" => "Which word is used for specifying an HTML tag that is inside another tag?"], //nesting
//         ["label" => "LAND", "value" => 8, "question" => "Which side of the box is the third number in: margin:1px 1px 1px 1px; ?"], //bottom
//         ["label" => "MOTOROLLA", "value" => 9, "question" => "What are the fonts that don't have serifs at the ends of letters called?"], //sans-serif
//         ["label" => "BMW", "value" => 10, "question" => "With CSS selectors, what character prefix should one use to specify a class?"] // class selector
//     ];

//     return response()->json($data);
// });

// $data = [
//     ["label" => "Dell LAPTOP", "value" => 1],
//     ["label" => "IMAC PRO", "value" => 2],
//     ["label" => "SUZUKI", "value" => 3],
//     ["label" => "HONDA", "value" => 4],
//     ["label" => "FERRARI", "value" => 5],
//     ["label" => "APARTMENT", "value" => 6],
//     ["label" => "IPAD PRO", "value" => 7],
//     ["label" => "LAND", "value" => 8],
//     ["label" => "MOTOROLLA", "value" => 9],
//     ["label" => "BMW", "value" => 10],
// ];
