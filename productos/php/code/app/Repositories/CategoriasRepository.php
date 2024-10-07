<?php

namespace App\Repositories;

use App\Http\Requests\CategoriasRequestValidate;
use App\Interfaces\CategoriasBaseInterface;
use App\Models\Categoria;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;


class CategoriasRepository implements CategoriasBaseInterface
{
    /**
     * Busca informacion de la categoria
     *
     * @param [int] $id identificador de la categoria
     * @return JsonResponse
     */
    public function find($id) : JsonResponse
    {
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'data'      => Categoria::findOrFail($id),
            'httpCode'  => 200
        ]);
    }

    /**
     * Retorna Listado de Categorias
     *
     * @return JsonResponse
     */
    public function all() : JsonResponse
    {
        return JsonResponseCustom::sendJson([
            'status' => true,
            'data' => Categoria::all(),
            'httpCode' => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }

    /**
     * Agrega Categoria
     *
     * @param CategoriasRequestValidate $data array con los datos de la categoria
     * @return JsonResponse
     */
    public function new(CategoriasRequestValidate $data) : JsonResponse
    {
        $categoria = Categoria::create($data->validated());
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'mensaje'   => 'Registro agregado',
            'data'      => $categoria->toArray(),
            'httpCode'  => 200
        ]);
    }

    /**
     * Actualizacion Sinple o Full de la categoria
     *
     * @param CategoriasRequestValidate $data array con los datos de la categoria
     * @param integer $id identificador de la categoria
     * @return JsonResponse
     */
    public function update(CategoriasRequestValidate $data, int $id) : JsonResponse
    {
        $data->validated();
        $categoria = Categoria::findOrFail($id);
        $categoria->fill($data->toArray());
        if (!$categoria->isDirty()) {
            return JsonResponseCustom::sendJson([
                'status' => true,
                'mensaje' => 'Sin Cambios a Actualizar',
                'data' => $categoria,
                'httpCode' => JsonResponseCustom::$CODE_SUCCESS
            ]);
        }
        $categoria->save();
        return JsonResponseCustom::sendJson([
            'status' => true,
            'mensaje' => 'Registro actualizado',
            'data' => $categoria,
            'httpCode' => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }

    /**
     * Borrar Categoria
     *
     * @param integer $id identificador de la categoria
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return JsonResponseCustom::sendJson([
            'status' => true,
            'mensaje' => 'Registro eliminado',
            'httpCode' => 200
        ]);
    }
}
