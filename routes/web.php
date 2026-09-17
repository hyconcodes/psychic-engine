<?php

use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('terms', 'terms')->name('terms');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('contact', 'contact')->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
    Route::post('plans/{plan:slug}/subscribe', [PlanController::class, 'subscribe'])->name('plans.subscribe');
    Route::get('plans/callback', [PlanController::class, 'callback'])->name('plans.callback');
});

require __DIR__.'/settings.php';
