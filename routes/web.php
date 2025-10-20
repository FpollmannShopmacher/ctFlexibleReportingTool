<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/view', 'statistics')->name('statistics');

Route::get('/dashboard', [StatisticsController::class, 'viewStatistic'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/fetch-statistic', [StatisticsController::class, 'viewStatistic'])->name('dashboard.fetch-statistic');
    Route::get('/dashboard/download/{type}', [StatisticsController::class, 'download'])->name('dashboard.download');
});

require __DIR__.'/auth.php';
