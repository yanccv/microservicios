<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class categoriaController extends Controller
{
    /**
     * Validacion de los campos del modelo Categoria
     */
    var $conditional = [
        'nombre'      => 'required'
    ];

    /**
     * listado de categorias - GET
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list() : \Illuminate\Http\JsonResponse
    {
        return $this->allData(Categoria::class);
    }


    /**
     * Agregar Registro de Categorias - POST
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) : \Illuminate\Http\JsonResponse
    {
        if (($validator = $this->validatorData($request->all(), $this->conditional)) !== true) {
            return $validator;
        }
        // return $this->addData(Categoria::class, $request);
        $addRecord = (object) $this->addData(Categoria::class, $request);
        if (!isset($addRecord->created)) {
            return $addRecord;
        } elseif ($addRecord->created) {
            return $this->responseJson(201, 'Registro Agregado', $addRecord->record->toArray());
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
        if (($validator = $this->validatorData($request->all(), $this->conditional)) !== true) {
            return $validator;
        }
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->update([
                'nombre' => $request->nombre,
            ]);
            return $this->responseJson(200, 'Actualizacion Exitosa', $categoria);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Categoria no encontrada');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar la Categoria', '', $th->getMessage());
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
        $conditional = array_intersect_key($this->conditional, $request->all());
        if (($validator = $this->validatorData($request->all(), $conditional)) !== true) {
            return $validator;
        }
        // return $this->updateSingle(Categoria::class, $id, $request);
        $updatedRecord =  (object) $this->updateSingle(Categoria::class, $id, $request);
        if (!isset($updatedRecord->updated)) {
            return $updatedRecord;
        } elseif ($updatedRecord->updated) {
            return $this->responseJson(200, 'Registro Actualizado', $updatedRecord->record);
        }
    }

    /**
     * Borrado de Registros - DELETE
     *
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        // return $this->destroyGeneral(Categoria::class, $id);
        $deletedRecord = (Object) $this->destroyGeneral(Categoria::class, $id);
        if (!isset($deletedRecord->deleted)) {
            return $deletedRecord;
        } elseif ($deletedRecord->deleted) {
            Queue::pushOn('usuariosQueue', 'userDeleted', ['id' => $id], 'user.deleted');
            return $this->responseJson(200, 'Registro eliminado');
        }
    }
}
