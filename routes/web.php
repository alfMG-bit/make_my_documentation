<?php

use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Livewire\Test;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
    Route::get('/login', [AuthenticatedUserController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedUserController::class, 'store'])->name('login.store');
});

Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware(['auth', 'verified']);

Route::middleware(['auth', 'verified'])->group(function() {
    Route::post('/logout', [AuthenticatedUserController::class, 'destroy'])
    ->name('logout.destroy');
});

Route::get('/test', function () {
    return view("test");
})->name("test");
