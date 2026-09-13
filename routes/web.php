<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PastorController;

// ዋና መነሻ ገጽ
Route::get('/', [HomeController::class, 'index'])->name('home');

// የፀሎት ጥያቄዎች
Route::get('/prayer-requests', [HomeController::class, 'prayerIndex'])->name('prayer.index');
Route::post('/prayer-requests', [HomeController::class, 'prayerStore'])->name('prayer.store');

// የፓስተሮች አገልግሎት እና ሚስጥራዊ ምክር
Route::get('/pastors', [PastorController::class, 'index'])->name('pastors.index');
Route::get('/pastors/{id}', [PastorController::class, 'show'])->name('pastors.show');
Route::post('/pastors/{id}/counseling', [PastorController::class, 'sendCounseling'])->name('pastors.counseling');
