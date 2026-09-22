<?php

use App\Http\Controllers\Admin\AdminEarningPromptController;
use App\Http\Controllers\Admin\AdminPlanController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
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
    Route::get('prompts/bulk-import', [AdminEarningPromptController::class, 'bulkImport'])->name('prompts.bulk-import');
    Route::post('prompts/bulk-import', [AdminEarningPromptController::class, 'storeBulkImport'])->name('prompts.bulk-import.store');
});
