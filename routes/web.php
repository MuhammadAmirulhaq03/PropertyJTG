<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

use App\Http\Controllers\JadwalController;
Route::get('/jadwal', [JadwalController::class, 'tampil'])->name('tampil.jadwal');
Route::post('/jadwal/simpan', [JadwalController::class, 'simpan'])->name('simpan.jadwal');
Route::delete('/jadwal/hapus/{id}', [JadwalController::class, 'hapus'])->name('hapus.jadwal');

use App\Http\Controllers\ContractorController;
Route::get('/contractor', [ContractorController::class, 'create'])->name('contractor.create');
Route::post('/contractor', [ContractorController::class, 'store'])->name('contractor.store');

use App\Http\Controllers\ConsultantController;
Route::get('/consultant', [ConsultantController::class, 'create'])->name('consultant.create');
Route::post('/consultant', [ConsultantController::class, 'store'])->name('consultant.store');

use App\Http\Controllers\FeedbackController;
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');


require __DIR__.'/auth.php';
 