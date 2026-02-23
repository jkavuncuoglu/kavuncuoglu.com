<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Root: detect locale from cookie / Accept-Language, redirect
Route::get('/', function (Request $request) {
    $cookie  = $request->cookie('locale');
    $supported = ['en', 'de', 'tr', 'es'];
    $browser = substr($request->getPreferredLanguage($supported) ?? 'en', 0, 2);
    $locale  = in_array($cookie, $supported) ? $cookie : (in_array($browser, $supported) ? $browser : 'en');

    return redirect('/' . $locale, 302);
});

// Locale-prefixed public routes
Route::prefix('{locale}')
    ->where(['locale' => 'en|de|tr|es'])
    ->group(function () {
        Route::get('/', WelcomeController::class)->name('home');

        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    });

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/chat.php';
