<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::resource('usuarios', UserController::class);

Route::patch('categorias/{categoria}/toggle-status', [CategoriaController::class, 'toggleStatus'])->name('categorias.toggleStatus');
Route::resource('categorias', CategoriaController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('usuarios', UserController::class);

    Route::patch('categorias/{categoria}/toggle-status', [CategoriaController::class, 'toggleStatus'])->name('categorias.toggleStatus');
    Route::resource('categorias', CategoriaController::class);

    Route::patch('productos/{producto}/toggle-status', [ProductoController::class, 'toggleStatus'])->name('productos.toggleStatus');
    Route::resource('productos', ProductoController::class);
});


require __DIR__ . '/settings.php';
