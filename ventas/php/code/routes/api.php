<?php

use App\Http\Controllers\Api\productoController;
use App\Http\Controllers\Api\usuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * Rutas de los productos
 */
// Route::get('/productos', [productoController::class, 'list']);
Route::get('/productos/{id}', [productoController::class, 'get']);
// Route::post('/productos', [productoController::class, 'add']);
// Route::put('/productos/{id}', [productoController::class, 'edit']);
// Route::delete('/productos/{id}', [productoController::class, 'destroy']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


/**
 * Rutas de los usuarios
 */
Route::get('/usuarios/{id}', [usuarioController::class, 'get']);
