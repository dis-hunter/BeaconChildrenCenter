<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page');
});
Route::get('/sign_in', function () {
    return view('sign_in');
});


Route::get('/register_child', function(){
    return view('register_child');
})->name('register_child');

