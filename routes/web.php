<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\FinanzasController;

// web.php
Route::get('/api/crypto', [CryptoController::class, 'getAllCryptoMarketsJson']);

Route::get('/crypto', function() {
    return view('crypto'); 
})->name('crypto');

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

Route::middleware(['auth'])->group(function() {
    Route::get('/finanzas', [FinanzasController::class,'index'])->name('finanzas.index');
    Route::post('/finanzas', [FinanzasController::class,'store'])->name('finanzas.store');
    Route::get('/finanzas/{id}/edit', [FinanzasController::class, 'edit'])->name('finanzas.edit');
    Route::put('/finanzas/{id}', [FinanzasController::class, 'update'])->name('finanzas.update');
    Route::delete('/finanzas/{id}', [FinanzasController::class,'destroy'])->name('finanzas.destroy');
});

Route::get('/stocks', function () {
    return view('stocks.index');
})->name('stocks');


require __DIR__.'/auth.php';
