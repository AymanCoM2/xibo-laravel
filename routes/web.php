<?php

use App\Models\Display;
use App\Models\Layout;
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


Route::get('/spin-win-page', function () {
    return view('screenGames.spin-win-p1');
})->name('spin-win-page-p1');
