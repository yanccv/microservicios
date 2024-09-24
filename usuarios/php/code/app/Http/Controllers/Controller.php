<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
    public function validatorData(array $request, array $conditions) : \Illuminate\Http\JsonResponse | bool
    {
        if (empty($request)) {
            return $this->responseJson(400, 'Formulario Vacio');
        }
        $validator = Validator::make($request, $conditions);
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
    public function addData($model, $request) : \Illuminate\Http\JsonResponse | array
    {
        try {
            $record = $model::create($request->all());
            return ['created' => true, 'record' => $record->toArray()];
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
    public function updateSingle($model, $id, $request) : \Illuminate\Http\JsonResponse | array
    {
        try {
            $record = $model::findOrFail($id);
            $record->fill($request->all());
            if (!$record->isDirty()) {
                return $this->responseJson(200, 'Sin Cambios a Actualizar', $record);
            }
            $fieldsUpdated = $record->getDirty();
            $record->save();
            $fieldsUpdated['id'] = $id;
            return ['updated' => true, 'record' => $fieldsUpdated];
            // return $this->responseJson(200, 'Actualizacion Exitosa', $record);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Registro no encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar', null, $th->getMessage());
        }
    }

    /**
     * Undocumented function
     *
     * @param $model Modelo del que se va a eliminar el registro
     * @param integer $id identificador del registro a eliminar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyGeneral($model, int $id) : \Illuminate\Http\JsonResponse | array
    {
        try {
            $registerToRemove = $model::findOrFail($id);
            $registerToRemove->delete();
            return ['deleted' => true];
            // return $this->responseJson(200, 'Registro eliminado');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Registro No encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al eliminar el registro', '', $th->getMessage());
        }
    }

}
