<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::resource('usuarios', UserController::class);

Route::patch('categoria/{categoria}/toggle-status', [CategoriaController::class, 'toggleStatus'])->name('categoria.toggleStatus');
Route::resource('categoria', CategoriaController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});


require __DIR__ . '/settings.php';
