<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;

// Guest Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard & Global Search
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('search', [DashboardController::class, 'search'])->name('search');

    // Profile Module
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Routes
    Route::resource('certificates', CertificateController::class);
    Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
    Route::get('certificates/{certificate}/preview', [CertificateController::class, 'preview'])->name('certificates.preview');

    Route::resource('education', EducationController::class);
    Route::get('education/{education}/download', [EducationController::class, 'download'])->name('education.download');

    Route::resource('work-experiences', WorkExperienceController::class);

    Route::resource('skills', SkillController::class);

    // Photos Module
    Route::get('photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::post('photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    Route::get('photos/{photo}/download', [PhotoController::class, 'download'])->name('photos.download');

    // Documents Module
    Route::resource('documents', DocumentController::class);
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Reports Module
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');

    // Settings Module
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/password', [SettingsController::class, 'changePassword'])->name('settings.password');
    Route::post('settings/theme', [SettingsController::class, 'toggleTheme'])->name('settings.theme');
    Route::get('settings/backup', [SettingsController::class, 'backupDatabase'])->name('settings.backup');
});
