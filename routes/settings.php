<?php

use App\Http\Controllers\Settings\KnowledgeBaseController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\TwoFactorAuthenticationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('user-password.edit');

    Route::put('settings/password', [PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('user-password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance.edit');

    Route::get('settings/two-factor', [TwoFactorAuthenticationController::class, 'show'])
        ->name('two-factor.show');

    Route::get('settings/knowledge-base', [KnowledgeBaseController::class, 'index'])
        ->name('knowledge-base.index');
    Route::post('settings/knowledge-base', [KnowledgeBaseController::class, 'store'])
        ->name('knowledge-base.store');
    Route::post('settings/knowledge-base/upload', [KnowledgeBaseController::class, 'upload'])
        ->name('knowledge-base.upload');
    Route::delete('settings/knowledge-base/{document}', [KnowledgeBaseController::class, 'destroy'])
        ->name('knowledge-base.destroy');
});
