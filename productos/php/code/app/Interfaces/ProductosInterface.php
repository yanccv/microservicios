<?php

namespace App\Interfaces;

// use App\Http\Requests\CategoriasRequestValidate;

use App\Http\Requests\ProductosRequestValidate;
use Illuminate\Http\JsonResponse;


interface ProductosInterface {
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
     * @param ProductosRequestValidate $data array con los datos de la categoria
     * @return JsonResponse
     */
    public function new(ProductosRequestValidate $data);

    /**
     * Actualizacion Sinple o Full de la categoria
     *
     * @param ProductosRequestValidate $data array con los datos de la categoria
     * @param integer $id identificador de la categoria
     * @return JsonResponse
     */
    public function update(ProductosRequestValidate $data, int $id);

    /**
     * Borrar Categoria
     *
     * @param integer $id identificador de la categoria
     * @return JsonResponse
     */
    public function delete(int $id);
}

