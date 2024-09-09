<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/list', function () {
    return 'Listado de Productos';
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
