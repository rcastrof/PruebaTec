<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\eventController;
use App\Http\Controllers\Api\purchaseController;

// Rutas para la visualización de eventos
Route::get('/events', [eventController::class, 'index']);
Route::get('/event', [eventController::class, 'show']);

// Rutas para la compra de entradas y la visualización de las compras realizadas
Route::post('/purchase', [purchaseController::class, 'purchase']);
Route::get('/orders', [purchaseController::class, 'order']);



