<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('lang/{lang}', function ($lang) {
    Session::put('locale', $lang);
    App::setLocale($lang);
    return redirect()->back();
})->name('lang.switch');

Route::get('/market-listings', [\App\Http\Controllers\MarketListingController::class, 'index'])
->name('market-listings.index');
