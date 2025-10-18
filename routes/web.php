<?php

use App\Http\Controllers\Admin\CrmController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\DokumenVerificationController as AdminDokumenVerificationController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PropertiController;
use App\Http\Controllers\Agen\DashboardController as AgenDashboardController;
use App\Http\Controllers\Agen\DokumenVerificationController as AgenDokumenVerificationController;
use App\Http\Controllers\Agen\ProfileController as AgenProfileController;
use App\Http\Controllers\Agen\ProgressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pelanggan\DokumenController;
use App\Http\Controllers\Pelanggan\HomeController;
use App\Http\Controllers\Pelanggan\ProfileController as PelangganProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/properties/search', [HomeController::class, 'search'])->name('properties.search');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified', 'can:view-dashboard'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [PelangganProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [PelangganProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PelangganProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/documents', [DokumenController::class, 'index'])->name('documents.index');
    Route::post('/documents', [DokumenController::class, 'store'])->name('documents.store');
    Route::get('/documents/{documentUpload}/download', [DokumenController::class, 'download'])
        ->whereNumber('documentUpload')
        ->name('documents.download');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', DashboardAdminController::class)->name('dashboard');

        Route::get('/properties', [PropertiController::class, 'index'])
            ->name('properties.index')
            ->middleware('can:manage-properties');

        Route::get('/crm', [CrmController::class, 'index'])
            ->name('crm.index')
            ->middleware('can:view-team-metrics');

        Route::get('/feedback', [FeedbackController::class, 'index'])
            ->name('feedback.index')
            ->middleware('can:view-team-metrics');

        Route::get('/schedule', [AdminJadwalController::class, 'index'])
            ->name('schedule.index')
            ->middleware('can:manage-schedule');

        Route::get('/documents', [AdminDokumenVerificationController::class, 'index'])
            ->name('documents.index')
            ->middleware('can:manage-documents');

        Route::get('/profile', [AdminProfileController::class, 'index'])
            ->name('profile.index')
            ->middleware('can:view-dashboard');
    });

Route::prefix('agent')
    ->name('agent.')
    ->middleware(['auth', 'verified', 'role:admin,agen'])
    ->group(function () {
        Route::get('/dashboard', AgenDashboardController::class)->name('dashboard');

        Route::get('/documents', [AgenDokumenVerificationController::class, 'index'])
            ->name('documents.index')
            ->middleware('can:manage-documents');
        Route::get('/documents/customers/{user}', [AgenDokumenVerificationController::class, 'show'])
            ->name('documents.show')
            ->middleware('can:manage-documents');
        Route::get('/documents/{documentUpload}/download', [AgenDokumenVerificationController::class, 'download'])
            ->name('documents.download')
            ->middleware('can:manage-documents');
        Route::patch('/documents/{documentUpload}', [AgenDokumenVerificationController::class, 'update'])
            ->name('documents.update')
            ->middleware('can:manage-documents');

        Route::get('/progress', [ProgressController::class, 'index'])
            ->name('progress.index')
            ->middleware('can:manage-properties');

        Route::get('/profile', [AgenProfileController::class, 'index'])
            ->name('profile.index')
            ->middleware('can:view-dashboard');
    });

require __DIR__.'/auth.php';
