<?php

use App\Http\Controllers\Api\usuarioController;
// use Illuminate\Http\Request;
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

Route::get('/users', [usuarioController::class, 'index']);

Route::get('/users/{id}', function () {
    return ['Retorna un Usuario'];
});

Route::post('/users', [usuarioController::class, 'store']);


Route::put('/users/{id}', [usuarioController::class, 'updatefull'])->where('id', '[0-9]+');


Route::patch('/users/{$id}', function () {
    return ['Edicion Parcial de  User'];
});

Route::delete('/users/{id}', [usuarioController::class, 'destroy'])->where('id', '[0-9]+');


// s
