<?php

namespace App\Interfaces;

use App\Http\Requests\CategoriasRequestValidate;
use Illuminate\Http\JsonResponse;


interface CategoriasBaseInterface {

    /**
     * Busca informacion de la categoria
     *
     * @param [int] $id identificador de la categoria
     * @return JsonResponse
     */
    public function find(int $id);

    /**
     * Retorna Listado de Categorias
     *
     * @return JsonResponse
     */
    public function all();

    /**
     * Agrega Categoria
     *
     * @param CategoriasRequestValidate $data array con los datos de la categoria
     * @return JsonResponse
     */
    public function new(CategoriasRequestValidate $data);

    /**
     * Actualizacion Sinple o Full de la categoria
     *
     * @param CategoriasRequestValidate $data array con los datos de la categoria
     * @param integer $id identificador de la categoria
     * @return JsonResponse
     */
    public function update(CategoriasRequestValidate $data, int $id);

    /**
     * Borrar Categoria
     *
     * @param integer $id identificador de la categoria
     * @return JsonResponse
     */
    public function delete(int $id);
}














