<?php

use App\Http\Controllers\LanguageController;
use App\Livewire\Dashboard\Profile\Profile;
use App\Livewire\Dashboard\User\UserData;
use Illuminate\Support\Facades\Route;

Route::middleware(['web-language'])->group(function () {
    Route::get('web-language/{lang}', LanguageController::class)->name('web-language');
    Route::view('/', 'welcome')->name('home');

    // authentication routes
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('profile', Profile::class)->name('profile'); // profile
        Route::view('dashboard', 'dashboard')->name('dashboard'); // dashboard
        Route::get('users', UserData::class)->name('users'); // users

    });

    // guest routes
    require __DIR__.'/auth.php';
});
