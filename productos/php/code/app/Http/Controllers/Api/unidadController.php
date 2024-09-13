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
     * @return Listado Completo de Unidades
     */
    public function list()
    {
        return $this->allData(Unidades::class);
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
        return $this->addData(Unidades::class, $request);
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
        return $this->updateSingle(Unidades::class, $id, $request);
    }

    /**
     * Borrado de Registros - DELETE
     *
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        return $this->destroyGeneral(Unidades::class, $id);
    }
}
