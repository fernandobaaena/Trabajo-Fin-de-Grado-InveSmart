<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\StockController;

Route::get('/stocks', [StockController::class, 'index']);
