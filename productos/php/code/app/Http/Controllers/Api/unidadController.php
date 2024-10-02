<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unidades;
use Illuminate\Http\Request;
use App\Interfaces\UnidadesRepositoryInterface;
// use App\Repositorys\unidadesRepository;

class unidadController extends Controller
{
    private $unidadRepository;

    public function __construct(UnidadesRepositoryInterface $unidadRepository)
    {
        $this->unidadRepository = $unidadRepository;
    }





    /**
     * listado de productos
     *
     * @return Listado Completo de Unidades
     */
    public function list()
    {
        return $this->unidadRepository->all();
    }



    /**
     * Agregar Registro de Unidades
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) : \Illuminate\Http\JsonResponse
    {
        if (($validator = $this->validatorData($request->all(), $this->conditional)) !== true) {
            return $validator;
        }
        $addRecord = (object) $this->addData(Unidades::class, $request);
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
        if (($validator = $this->validatorData($request, $this->conditional)) !== true) {
            return $validator;
        }
        try {
            $unidad = Unidades::findOrFail($id);
            $unidad->update([
                'nombre' => $request->nombre,
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
        if (($validator = $this->validatorData($request->all(), $conditional)) !== true) {
            return $validator;
        }
        $updatedRecord =  (object) $this->updateSingle(Unidades::class, $id, $request);
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
        // return $this->destroyGeneral(Unidades::class, $id);
        $deletedRecord = (Object) $this->destroyGeneral(Unidades::class, $id);
        if (!isset($deletedRecord->deleted)) {
            return $deletedRecord;
        } elseif ($deletedRecord->deleted) {
            return $this->responseJson(200, 'Registro eliminado');
        }
    }
}
