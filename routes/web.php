<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/prayer-requests', [HomeController::class, 'prayerIndex'])->name('prayer.index');
Route::post('/prayer-requests', [HomeController::class, 'prayerStore'])->name('prayer.store');

Route::get('/teachings', function () {
    $teachings = \App\Models\Teaching::latest()->paginate(12);
    return view('teachings.index', compact('teachings'));
})->name('teachings.index');

Route::get('/pastors', function () {
    $pastors = \App\Models\User::where('role', 'pastor')->get();
    return view('pastors.index', compact('pastors'));
})->name('pastors.index');
