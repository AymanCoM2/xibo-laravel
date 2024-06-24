<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home-page');
})->name('home-page');

// ! =============== From here i will Put the Routes Related to the STORE 
