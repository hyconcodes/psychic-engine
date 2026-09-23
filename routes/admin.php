<?php

use App\Http\Controllers\Admin\AdminBalanceController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEarningPromptController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminPayoutController;
use App\Http\Controllers\Admin\AdminPlanController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban', [AdminUserController::class, 'unban'])->name('users.unban');

    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::post('messages/{message}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');
    Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    Route::get('plans', [AdminPlanController::class, 'index'])->name('plans.index');
    Route::get('plans/{plan}/edit', [AdminPlanController::class, 'edit'])->name('plans.edit');
    Route::put('plans/{plan}', [AdminPlanController::class, 'update'])->name('plans.update');
    Route::post('plans/{plan}/toggle', [AdminPlanController::class, 'toggle'])->name('plans.toggle');

    Route::get('withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('withdrawals/audio/{submission}', [AdminWithdrawalController::class, 'audio'])->name('withdrawals.audio');
    Route::get('withdrawals/{withdrawal}', [AdminWithdrawalController::class, 'show'])->name('withdrawals.review');
    Route::post('withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('withdrawals/{withdrawal}/deduct', [AdminWithdrawalController::class, 'deduct'])->name('withdrawals.deduct');
    Route::post('withdrawals/{withdrawal}/decline', [AdminWithdrawalController::class, 'decline'])->name('withdrawals.decline');

    Route::get('prompts', [AdminEarningPromptController::class, 'index'])->name('prompts.index');
    Route::get('prompts/create', [AdminEarningPromptController::class, 'create'])->name('prompts.create');
    Route::post('prompts', [AdminEarningPromptController::class, 'store'])->name('prompts.store');
    Route::get('prompts/{prompt}/edit', [AdminEarningPromptController::class, 'edit'])->name('prompts.edit');
    Route::put('prompts/{prompt}', [AdminEarningPromptController::class, 'update'])->name('prompts.update');
    Route::post('prompts/{prompt}/toggle', [AdminEarningPromptController::class, 'toggle'])->name('prompts.toggle');
    Route::delete('prompts/{prompt}', [AdminEarningPromptController::class, 'destroy'])->name('prompts.destroy');
    Route::get('balances', [AdminBalanceController::class, 'index'])->name('balances.index');
    Route::get('balances/{balance}', [AdminBalanceController::class, 'show'])->name('balances.show');
    Route::post('balances/{balance}/process', [AdminBalanceController::class, 'process'])->name('balances.process');

    Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [AdminSettingsController::class, 'update'])->name('settings.update');

    Route::get('payouts', [AdminPayoutController::class, 'index'])->name('payouts.index');
    Route::get('payouts/create', [AdminPayoutController::class, 'create'])->name('payouts.create');
    Route::post('payouts/bank', [AdminPayoutController::class, 'storeBank'])->name('payouts.store-bank');
    Route::get('payouts/bank/edit', [AdminPayoutController::class, 'edit'])->name('payouts.edit-bank');
    Route::put('payouts/bank', [AdminPayoutController::class, 'updateBank'])->name('payouts.update-bank');
    Route::post('payouts/process', [AdminPayoutController::class, 'process'])->name('payouts.process');
});
