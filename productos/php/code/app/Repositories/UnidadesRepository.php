<?php

namespace App\Repositories;

use App\Http\Requests\unidadesRequestValidate;
use App\Interfaces\UnidadesRepositoryInterface;
use App\Models\Unidades;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\Request;

class UnidadesRepository implements UnidadesRepositoryInterface
{
    private $unidad;


    public function __construct(Unidades $unidad)
    {
        $this->unidad = $unidad;
    }

    public function find($id)
    {
        return JsonResponseCustom::sendJson([
            'status'    => true,
            'data'      => $this->unidad->findOrFail($id),
            'httpCode'  => 200
        ]);
    }

    public function all()
    {
        return JsonResponseCustom::sendJson([
            'status' => true,
            'data' => $this->unidad->all(),
            'httpCode' => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }

    public function new(unidadesRequestValidate $data)
    {
        return $this->unidad->create($data->validated());
    }

    public function update(unidadesRequestValidate $data, Unidades $unidad)
    {
        print_r($data->validated());
        $unidad->fill($data->validated());
        if (!$unidad->isDirty()) {
            return JsonResponseCustom::sendJson([
                'status' => true,
                'mensaje' => 'Sin Cambios a Actualizar',
                'data' => $unidad,
                'httpCode' => JsonResponseCustom::$CODE_SUCCESS
            ]);
        }
        $unidad->save();
        return JsonResponseCustom::sendJson([
            'status' => true,
            'mensaje' => 'Registro actualizado',
            'data' => $unidad,
            'httpCode' => JsonResponseCustom::$CODE_SUCCESS
        ]);
    }
}
