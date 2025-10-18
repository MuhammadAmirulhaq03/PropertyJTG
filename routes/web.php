<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KprCalculatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kalkulator-kpr', [KprCalculatorController::class, 'show'])->name('kpr.calculator.show');
    Route::post('/kalkulator-kpr', [KprCalculatorController::class, 'calculate'])->name('kpr.calculator.calculate');
});

require __DIR__.'/auth.php';
