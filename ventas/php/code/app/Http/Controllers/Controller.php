<?php

namespace App\Http\Controllers;

abstract class Controller
{
        /**
     * respuesta generalizada de la Api solo en formato Json
     *
     * @param integer $httpCode
     * @param string $message Mensaje que se entregar
     * @param [array] $data informacion a entregar
     * @param string|null $error si ocurre se entregara
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson(int $httpCode, string $message, $data = null, string $error = null) : \Illuminate\Http\JsonResponse
    {
        $response = array_filter([
            'message' => $message,
            'data' => $data,
            'error' => $error,
            'status' => $httpCode
        ]);

        return response()->json($response, $httpCode);
    }

    /**
     * Valida la data que ingresa desde el Front
     *
     * @param Request $request Data a Validar
     * @param array $conditions validaciones a realizar campo a campo
     * @return \Illuminate\Http\JsonResponse | true
     */
    public function validatorData(Request $request, array $conditions) : \Illuminate\Http\JsonResponse | true
    {
        if (empty($request->all())) {
            return $this->responseJson(400, 'Formulario Vacio');
        }
        $validator = Validator::make($request->all(), $conditions);
        if ($validator->fails()) {
            return $this->responseJson(400, 'Error en la validación de los datos',null, $validator->errors());
        }
        return true;
    }


        /**
     * Insertar Nuevo Registro
     *
     * @param [type] $model Modelo donde se va a insertar el registro
     * @param [type] $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function addData($model, $request) : \Illuminate\Http\JsonResponse
    {
        try {
            $categoria = $model::create($request->all());
            return $this->responseJson(201, 'Registro Agregado', $categoria);
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al Crear ', '', $th->getMessage());
        }
    }


    /**
     * Actualizacion Simple Macro
     *
     * @param [type] $model Donde se realizaran las operaciones
     * @param [type] $id
     * @param [type] $request Valores actualizables
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSingle($model, $id, $request) : \Illuminate\Http\JsonResponse
    {
        try {
            $unidad = $model::findOrFail($id);
            $unidad->fill($request->all());
            if (!$unidad->isDirty()) {
                return $this->responseJson(200, 'Sin Cambios a Actualizar', $unidad);
            }
            $unidad->save();
            return $this->responseJson(200, 'Actualizacion Exitosa', $unidad);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Registro no encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar la Unidad', null, $th->getMessage());
        }
    }

    /**
     * Undocumented function
     *
     * @param $model Modelo del que se va a eliminar el registro
     * @param integer $id identificador del registro a eliminar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyGeneral($model, int $id) : \Illuminate\Http\JsonResponse
    {
        try {
            $registerToRemove = $model::findOrFail($id);
            $registerToRemove->delete();
            return $this->responseJson(200, 'Registro eliminado');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Registro No encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al eliminar el registro', '', $th->getMessage());
        }
    }
}
