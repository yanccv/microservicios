<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\categoriaController;
use App\Http\Controllers\Api\productoController;
use App\Http\Controllers\Api\unidadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Rutas de los productos
 */
Route::get('/productos', [productoController::class, 'list']);
Route::get('/productos/{id}', [productoController::class, 'getProducto']);
Route::post('/productos', [productoController::class, 'add']);
Route::put('/productos/{id}', [productoController::class, 'edit']);
Route::patch('/productos/{id}', [productoController::class, 'set']);
Route::delete('/productos/{id}', [productoController::class, 'destroy']);

/**
 * Routas de las Categorias
 */
Route::get('/categorias', [categoriaController::class, 'list']);
Route::get('/categorias/{id}', [categoriaController::class, 'getCategoria']);
Route::post('/categorias', [categoriaController::class, 'add']);
Route::put('/categorias/{id}', [categoriaController::class, 'edit']);
Route::patch('/categorias/{id}', [categoriaController::class, 'set']);
Route::delete('/categorias/{id}', [categoriaController::class, 'destroy']);

/**
 * Routas de las Categorias
 */
Route::get('/unidades', [unidadController::class, 'list']);
Route::get('/unidades/{id}', [unidadController::class, 'getUnidad']);
Route::post('/unidades', [unidadController::class, 'add']);
Route::put('/unidades/{id}', [unidadController::class, 'edit']);
Route::patch('/unidades/{id}', [unidadController::class, 'set']);
Route::delete('/unidades/{id}', [unidadController::class, 'destroy']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
