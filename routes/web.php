<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('terms', 'terms')->name('terms');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('contact', 'contact')->name('contact');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
    Route::post('plans/{plan:slug}/subscribe', [PlanController::class, 'subscribe'])->name('plans.subscribe');
    Route::get('plans/callback', [PlanController::class, 'callback'])->name('plans.callback');
    Route::get('plans/cancelled', [PlanController::class, 'cancelled'])->name('plans.cancelled');

    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

    Route::livewire('earn', 'pages::earn.index')->name('earn.index');
    Route::livewire('earn/voice', 'pages::earn.record')->name('earn.voice')->defaults('type', 'sentence');
    Route::livewire('earn/word-game', 'pages::earn.record')->name('earn.word-game')->defaults('type', 'word');
});

require __DIR__.'/settings.php';
