<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home-page');
})->name('home-page');

// ! =============== From here i will Put the Routes Related to the STORE 

Route::get('/create-store', function () {
    return view('stores.create');
})->name('create-store');


Route::get('/manage-stores', function () {
    return view('stores.manage');
})->name('manage-stores');


// * Here are the Routes Related to the Products Links 

Route::get('/create-product', function () {
    return view('products.create');
})->name('create-product');


Route::get('/manage-products', function () {
    return view('products.manage');
})->name('manage-products');
