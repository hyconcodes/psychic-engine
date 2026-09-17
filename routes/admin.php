<?php

use App\Http\Controllers\Admin\AdminPlanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('plans', [AdminPlanController::class, 'index'])->name('plans.index');
    Route::get('plans/{plan}/edit', [AdminPlanController::class, 'edit'])->name('plans.edit');
    Route::put('plans/{plan}', [AdminPlanController::class, 'update'])->name('plans.update');
    Route::post('plans/{plan}/toggle', [AdminPlanController::class, 'toggle'])->name('plans.toggle');
});
