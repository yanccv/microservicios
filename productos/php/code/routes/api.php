<?php

use App\Http\Controllers\Api\categoriaController;
use App\Http\Controllers\Api\productoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Rutas de los productos
 */
Route::get('/productos', [productoController::class, 'list']);
Route::post('/productos', [productoController::class, 'add']);
Route::put('/productos/{id}', [productoController::class, 'edit']);
Route::delete('/productos/{id}', [productoController::class, 'destroy']);

/**
 * Routas de las Categorias
 */
Route::get('/categorias', [categoriaController::class, 'list']);
Route::post('/categorias', [categoriaController::class, 'add']);
Route::put('/categorias/{id}', [categoriaController::class, 'edit']);
Route::delete('/categorias/{id}', [categoriaController::class, 'destroy']);

