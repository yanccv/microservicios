<?php

namespace App\Repositories;

use App\Http\Requests\UnidadesRequestValidate;
use App\Interfaces\UnidadesRepositoryInterface;
use App\Models\Unidades;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;

class UnidadesRepository implements UnidadesRepositoryInterface
{
    /**
     * Buscar informacion de la unidad del id pasado
     *
     * @param [int] $id
     * @return JsonResponse
     */
    public function find(int $id) : JsonResponse
    {
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'data'      => Unidades::findOrFail($id),
            'httpCode'  => 200
        ]);
    }

    /**
     * Listado de Unidades
     *
     * @return JsonResponse
     */
    public function all() : JsonResponse
    {
        return JsonResponseCustom::sendJson([
            'status' => true,
            'data' => Unidades::all(),
            'httpCode' => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }

    /**
     * Agrega nueva unidad
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new(UnidadesRequestValidate $data) : JsonResponse
    {
        $unidad = Unidades::create($data->validated());
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'mensaje'   => 'Registro agregado',
            'data'      => $unidad->toArray(),
            'httpCode'  => 200
        ]);
    }

    /**
     * Actualizacion de Registro
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @param integer $id identificador de la unidad a actualizar
     * @return JsonResponse
     */
    public function update(UnidadesRequestValidate $data, int $id) : JsonResponse
    {
        $data->validated();
        $unidad = Unidades::findOrFail($id);
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
        $unidad = Unidades::findOrFail($id);
        $unidad->delete();
        return JsonResponseCustom::sendJson([
            'status' => true,
            'mensaje' => 'Registro eliminado',
            'httpCode' => 200
        ]);
    }
}
