<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\unidadesRequestValidate;
use App\Models\Unidades;
use Illuminate\Http\Request;
use App\Interfaces\UnidadesRepositoryInterface;
use App\Utilities\JsonResponseCustom;

// use App\Repositorys\unidadesRepository;

class unidadController extends Controller
{
    private $unidadRepository;

    public function __construct(UnidadesRepositoryInterface $unidadRepository)
    {
        $this->unidadRepository = $unidadRepository;
    }





    /**
     *  Listado Completo de Unidades
     * @return \Illuminate\Http\JsonResponse
     */
    public function list() : \Illuminate\Http\JsonResponse
    {
        return $this->unidadRepository->all();
    }


    /**
     * Obtener  Unidad - GET
     *
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnidad(int $id) : \Illuminate\Http\JsonResponse
    {
        return $this->unidadRepository->find($id);

    }


    /**
     * Agregar Registro de Unidades
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(unidadesRequestValidate $request) : \Illuminate\Http\JsonResponse
    {
        return $this->unidadRepository->new($request);
    }

    /**
     * Modificacion Completa - PUT
     *
     * @param Request $request Todos los valores actualizables
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(unidadesRequestValidate $request, int $id) : \Illuminate\Http\JsonResponse
    {
        return $this->unidadRepository->update($request, $id);
    }

    /**
     * Modificacion Simple - PATCH
     *
     * @param Request $request Valores a actualizar
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function set(unidadesRequestValidate $request, int $id) : \Illuminate\Http\JsonResponse
    {
        // $unidad = Unidades::findOrFail($id);
        return $this->unidadRepository->update($request, $id);
        //return array_intersect_key($request->all(), $this->conditional);
        // $conditional = array_intersect_key($this->conditional, $request->all());
        // if (($validator = $this->validatorData($request->all(), $conditional)) !== true) {
        //     return $validator;
        // }
        // $updatedRecord =  (object) $this->updateSingle(Unidades::class, $id, $request);
        // if (!isset($updatedRecord->updated)) {
        //     return $updatedRecord;
        // } elseif ($updatedRecord->updated) {
        //     return $this->responseJson(200, 'Registro Actualizado', $updatedRecord->record);
        // }
    }

    /**
     * Borrado de Registros - DELETE
     *
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        return $this->unidadRepository->delete($id);
        // return $this->destroyGeneral(Unidades::class, $id);
        // $deletedRecord = (Object) $this->destroyGeneral(Unidades::class, $id);
        // if (!isset($deletedRecord->deleted)) {
        //     return $deletedRecord;
        // } elseif ($deletedRecord->deleted) {
        //     return $this->responseJson(200, 'Registro eliminado');
        // }
    }
}
