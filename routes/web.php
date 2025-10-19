<?php

use App\Http\Controllers\Admin\CrmController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\DokumenVerificationController as AdminDokumenVerificationController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PropertiController;
use App\Http\Controllers\Admin\VisitScheduleController;
use App\Http\Controllers\Agen\DashboardController as AgenDashboardController;
use App\Http\Controllers\Agen\DokumenVerificationController as AgenDokumenVerificationController;
use App\Http\Controllers\Agen\ProfileController as AgenProfileController;
use App\Http\Controllers\Agen\ProgressController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pelanggan\DokumenController;
use App\Http\Controllers\Pelanggan\FeedbackController as PelangganFeedbackController;
use App\Http\Controllers\Pelanggan\HomeController;
use App\Http\Controllers\Pelanggan\KprCalculatorController;
use App\Http\Controllers\Pelanggan\PropertyGalleryController;
use App\Http\Controllers\Pelanggan\ProfileController as PelangganProfileController;
use App\Http\Controllers\Pelanggan\VisitScheduleBookingController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/properties/search', [HomeController::class, 'search'])->name('properties.search');
Route::get('/gallery', [PropertyGalleryController::class, 'index'])->name('gallery.index');

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

    Route::middleware('role:customer')->group(function () {
        Route::get('/feedback', [PelangganFeedbackController::class, 'create'])->name('pelanggan.feedback.create');
        Route::post('/feedback', [PelangganFeedbackController::class, 'store'])->name('pelanggan.feedback.store');

        Route::get('/consultants', [ConsultantController::class, 'create'])->name('pelanggan.consultants.create');
        Route::post('/consultants', [ConsultantController::class, 'store'])->name('pelanggan.consultants.store');

        Route::get('/contractors', [ContractorController::class, 'create'])->name('pelanggan.contractors.create');
        Route::post('/contractors', [ContractorController::class, 'store'])->name('pelanggan.contractors.store');

        Route::get('/visit-schedules', [VisitScheduleBookingController::class, 'index'])->name('pelanggan.jadwal.index');
        Route::post('/visit-schedules/{visitSchedule}/book', [VisitScheduleBookingController::class, 'book'])->name('pelanggan.jadwal.book');
        Route::delete('/visit-schedules/{visitSchedule}', [VisitScheduleBookingController::class, 'cancel'])->name('pelanggan.jadwal.cancel');

        Route::get('/kpr/calculator', [KprCalculatorController::class, 'show'])->name('pelanggan.kpr.show');
        Route::post('/kpr/calculator', [KprCalculatorController::class, 'calculate'])->name('pelanggan.kpr.calculate');
    });
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', DashboardAdminController::class)->name('dashboard');

        Route::post('/properties/bulk-status', [PropertiController::class, 'bulkStatus'])
            ->name('properties.bulk-status')
            ->middleware('can:manage-properties');

        Route::resource('properties', PropertiController::class)
            ->except(['show'])
            ->middleware('can:manage-properties');

        Route::get('/crm', [CrmController::class, 'index'])
            ->name('crm.index')
            ->middleware('can:view-team-metrics');

        Route::get('/feedback', [FeedbackController::class, 'index'])
            ->name('feedback.index')
            ->middleware('can:view-team-metrics');

        Route::get('/feedback/export', [FeedbackController::class, 'export'])
            ->name('feedback.export')
            ->middleware('can:view-team-metrics');

        Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])
            ->name('feedback.destroy')
            ->middleware('can:view-team-metrics');

        Route::get('/schedule', [AdminJadwalController::class, 'index'])
            ->name('schedule.index')
            ->middleware('can:manage-schedule');

        Route::get('/documents', [AdminDokumenVerificationController::class, 'index'])
            ->name('documents.index')
            ->middleware('can:manage-documents');

        Route::resource('visit-schedules', VisitScheduleController::class)->except(['show']);
        Route::patch('/visit-schedules/{visitSchedule}/close', [VisitScheduleController::class, 'close'])->name('visit-schedules.close');
        Route::patch('/visit-schedules/{visitSchedule}/reopen', [VisitScheduleController::class, 'reopen'])->name('visit-schedules.reopen');

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





