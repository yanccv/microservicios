<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/productos', [ProductoController::class, 'new']);
Route::get('/productos', [ProductoController::class, 'list']);
Route::put('/productos/{id}', [ProductoController::class, 'edit']);
Route::delete('/productos/{id}', [ProductoController::class, 'delete']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
