<?php

namespace App\Repositories;

use App\Http\Requests\unidadesRequestValidate;
use App\Interfaces\UnidadesRepositoryInterface;
use App\Models\Unidades;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;

class UnidadesRepository implements UnidadesRepositoryInterface
{
    public function find($id) : JsonResponse
    {
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'data'      => Unidades::findOrFail($id),
            'httpCode'  => 200
        ]);
    }

    public function all() : JsonResponse
    {
        return JsonResponseCustom::sendJson([
            'status' => true,
            'data' => Unidades::all(),
            'httpCode' => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }

    public function new(unidadesRequestValidate $data) : JsonResponse
    {
        $unidad = Unidades::create($data->validated());
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'mensaje'   => 'Registro agregado',
            'data'      => $unidad->toArray(),
            'httpCode'  => 200
        ]);
    }


    public function update(unidadesRequestValidate $data, int $id) : JsonResponse
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
