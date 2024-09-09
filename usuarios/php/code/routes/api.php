<?php

use App\Http\Controllers\Api\usuarioController;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
