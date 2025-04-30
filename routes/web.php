<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SorteoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/sorteos', [SorteoController::class, 'index'])->name('sorteos.index');
    Route::get('/sorteos/{sorteo}/comprar', [CompraController::class, 'index'])->name('sorteos.comprar');
});

require __DIR__.'/auth.php';
