<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\facturaController;
use App\Http\Controllers\Api\productoController;
use App\Http\Controllers\Api\usuarioController;

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
// Route::get('/productos', [productoController::class, 'list']);
Route::get('/productos/{id}', [productoController::class, 'get']);
Route::post('/productos', [productoController::class, 'add']);
Route::patch('/productos/{id}', [productoController::class, 'edit']);
Route::delete('/productos/{id}', [productoController::class, 'destroy']);


/**
 * Rutas de los usuarios
 */
Route::get('/usuarios/{id}', [usuarioController::class, 'get']);
Route::post('/usuarios', [usuarioController::class, 'add']);
Route::patch('/usuarios/{id}', [usuarioController::class, 'edit']);
Route::delete('/usuarios/{id}', [usuarioController::class, 'destroy']);


/**
 * Rutas de las facturas
 */
Route::get('/facturas/{id}', [facturaController::class, 'get']);
Route::post('/facturas', [facturaController::class, 'add']);
// Route::patch('/facturas/{id}', [facturaController::class, 'edit']);
Route::delete('/facturas/{id}', [facturaController::class, 'destroy']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
