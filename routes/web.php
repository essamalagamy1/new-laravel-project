<?php

use App\Livewire\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::get('users', UserData::class)->middleware(['auth', 'verified'])->name('users');



require __DIR__.'/auth.php';
