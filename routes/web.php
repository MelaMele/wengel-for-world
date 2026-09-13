<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pastors', function () {
    return view('pastors.index');
})->name('pastors.index');

Route::get('/teachings', function () {
    return view('teachings.index');
})->name('teachings.index');

Route::get('/prayer-request', function () {
    return view('prayer.index');
})->name('prayer.index');
