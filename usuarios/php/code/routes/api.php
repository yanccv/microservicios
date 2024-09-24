<?php

use App\Http\Controllers\Api\usuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/usuarios', [usuarioController::class, 'index']);

Route::get('/usuarios/{id}', [usuarioController::class, 'get'])->where('id', '[0-9]+');

Route::post('/usuarios', [usuarioController::class, 'add']);

Route::put('/usuarios/{id}', [usuarioController::class, 'edit'])->where('id', '[0-9]+');


Route::patch('/usuarios/{id}', [usuarioController::class, 'set'])->where('id', '[0-9]+');

Route::delete('/usuarios/{id}', [usuarioController::class, 'destroy'])->where('id', '[0-9]+');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
