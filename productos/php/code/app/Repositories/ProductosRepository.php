<?php

namespace App\Repositories;

use App\Http\Requests\ProductosRequestValidate;
use App\Interfaces\ProductosInterface;
use App\Models\Producto;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;

class ProductosRepository implements ProductosInterface
{
    /**
     * Buscar informacion del prodicto del $id pasado
     *
     * @param [int] $id
     * @return JsonResponse
     */
    public function find(int $id) : JsonResponse
    {
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'data'      => Producto::findOrFail($id),
            'httpCode'  => 200
        ]);
    }

    /**
     * Listado de Productos
     *
     * @return JsonResponse
     */
    public function all() : JsonResponse
    {
        return JsonResponseCustom::sendJson([
            'status' => true,
            'data' => Producto::all(),
            'httpCode' => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }

    /**
     * Agrega nueva unidad
     *
     * @param ProductosRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new(ProductosRequestValidate $data) : JsonResponse
    {
        $producto = Producto::create($data->validated());
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'mensaje'   => 'Registro agregado',
            'data'      => $producto->toArray(),
            'httpCode'  => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }

    /**
     * Actualizacion de Registro
     *
     * @param ProductosRequestValidate $data array con los datos
     * @param integer $id identificador de la unidad a actualizar
     * @return JsonResponse
     */
    public function update(ProductosRequestValidate $data, int $id) : JsonResponse
    {
        $data->validated();
        $unidad = Producto::findOrFail($id);
        $unidad->fill($data->toArray());
        if (!$unidad->isDirty()) {
            return JsonResponseCustom::sendJson([
                'status' => true,
                'mensaje' => 'Sin Cambios a Actualizar',
                'data' => $unidad->toArray(),
                'httpCode' => JsonResponseCustom::$CODE_SUCCESS
            ]);
        }
        $unidad->save();
        return JsonResponseCustom::sendJson([
            'status' => true,
            'mensaje' => 'Registro actualizado',
            'data' => $unidad->toArray(),
            'httpCode' => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }

    /**
     * Borrar unidad
     *
     * @param integer $id identificador de la unidad a borrar
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        $unidad = Producto::findOrFail($id);
        $unidad->delete();
        return JsonResponseCustom::sendJson([
            'status' => true,
            'mensaje' => 'Registro eliminado',
            'httpCode' => 200
        ]);
    }
}
