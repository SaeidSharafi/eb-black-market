<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\MarketListingController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Test route for debugging
Route::get('/test', function() {
    return view('test');
})->name('test');

Route::get('lang/{lang}', function ($lang) {
    Session::put('locale', $lang);
    App::setLocale($lang);
    return redirect()->back();
})->name('lang.switch');

Route::get('/market-listings', [MarketListingController::class, 'index'])
->name('market-listings.index');

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::post('/telegram/webhook', [\App\Http\Controllers\TelegramWebhookController::class, 'handle']);
Route::get('/telegram/auth/callback', [\App\Http\Controllers\TelegramAuthController::class, 'handleCallback'])->name('telegram.auth.callback');
Route::get('/telegram/auth', [\App\Http\Controllers\TelegramAuthController::class, 'handleCallback'])->name('telegram.auth.callback');
Route::get('/telegram/link/callback', [\App\Http\Controllers\TelegramLinkController::class, 'handleCallback'])->name('telegram.link.callback')->middleware('auth');

