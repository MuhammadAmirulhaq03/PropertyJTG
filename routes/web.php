<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DocumentUploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'can:view-dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'can:manage-documents'])->group(function () {
    Route::get('/documents', [DocumentUploadController::class, 'index'])->name('documents.index');
    Route::post('/documents', [DocumentUploadController::class, 'store'])->name('documents.store');
    Route::get('/documents/{documentUpload}/download', [DocumentUploadController::class, 'download'])
        ->whereNumber('documentUpload')
        ->name('documents.download');
});

require __DIR__.'/auth.php';
