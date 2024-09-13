<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unidades;
use Illuminate\Http\Request;

class unidadController extends Controller
{
    var $conditional = [
        'unidad'    => 'required',
        'siglas'    => 'required'
    ];

    /**
     * listado de productos
     *
     * @return Listado de Categorias
     */
    public function list()
    {
        $data = Unidades::all();
        if ($data->isEmpty()) {
            return $this->responseJson(200, 'No se encontraron Unidades');
        } else {
            return $this->responseJson(200, '', $data);
        }
    }



     /**
      * Agregar Registro de Unidades
      *
      * @param Request $request Valores a insertar
      * @return \Illuminate\Http\JsonResponse
      */
    public function add(Request $request) : \Illuminate\Http\JsonResponse
    {
        if (($validator = $this->validatorData($request, $this->conditional)) !== true) {
            return $validator;
        }
        try {
            $unidad = Unidades::create([
                'unidad' => $request->unidad
            ]);
            return $this->responseJson(201, 'Unidad Agregada', $unidad);
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al crear la unidad', '', $th->getMessage());
        }

    }

    /**
     * Modificacion Completa - PUT
     *
     * @param Request $request Todos los valores actualizables
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, int $id) : \Illuminate\Http\JsonResponse
    {
        if (($validator = $this->validatorData($request, $this->conditional)) !== true) {
            return $validator;
        }
        try {
            $unidad = Unidades::findOrFail($id);
            $unidad->update([
                'unidad' => $request->unidad,
            ]);
            return $this->responseJson(200, 'Actualizacion Exitosa', $unidad);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Unidad no encontrada');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar la Unidad', '', $th->getMessage());
        }
    }

    /**
     * Modificacion Simple - PATCH
     *
     * @param Request $request Valores a actualizar
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse responseJson()
     */
    public function set(Request $request, int $id) : \Illuminate\Http\JsonResponse
    {
        //return array_intersect_key($request->all(), $this->conditional);
        $conditional = array_intersect_key($this->conditional, $request->all());
        if (($validator = $this->validatorData($request, $conditional)) !== true) {
            return $validator;
        }
        try {
            $unidad = Unidades::findOrFail($id);
            print_r($request->only(array_keys($conditional)));
            $unidad->fill($request->all());
            if (!$unidad->isDirty()) {
                return $this->responseJson(200, 'Sin Cambios a Actualizar', $unidad);
            }
            $unidad->save();
            return $this->responseJson(200, 'Actualizacion Exitosa', $unidad);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Unidad no encontrada');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar la Unidad', '', $th->getMessage());
        }
    }

    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        return $this->destroyGeneral(Unidades::class, $id);
    }
}
