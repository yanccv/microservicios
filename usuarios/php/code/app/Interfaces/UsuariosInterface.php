<?php

namespace App\Interfaces;

use App\Http\Requests\UsuariosRequestValidate;
use Illuminate\Http\JsonResponse;

interface UsuariosInterface {
    /**
     * Busca informacion de los usuarios
     *
     * @param [int] $id identificador de la categoria
     * @return JsonResponse
     */
    public function find(int $id) : JsonResponse;

    /**
     * Retorna Listado de usuarios
     *
     * @return JsonResponse
     */
    public function all() :JsonResponse;

    /**
     * Agrega Usuarios
     *
     * @param UsuariosRequestValidate $data array con los datos de la usuarios
     * @return JsonResponse
     */
    public function new(UsuariosRequestValidate $data) : JsonResponse;

    /**
     * Actualizacion Sinple o Full de la usuarios
     *
     * @param UsuariosRequestValidate $data array con los datos de la usuarios
     * @param integer $id identificador de la usuarios
     * @return JsonResponse
     */
    public function update(UsuariosRequestValidate $data, int $id) : JsonResponse;

    /**
     * Borrar Usuarios
     *
     * @param integer $id identificador de la usuarios
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse;
}
