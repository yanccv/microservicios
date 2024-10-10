<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadesRequestValidate;
use App\Interfaces\UnidadesRepositoryInterface;
use Illuminate\Http\JsonResponse;

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
    public function list() : JsonResponse
    {
        return $this->unidadRepository->all();
    }


    /**
     * Obtener  Unidad - GET
     *
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function getUnidad(int $id) : JsonResponse
    {
        return $this->unidadRepository->find($id);

    }


    /**
     * Agregar Registro de Unidades
     *
     * @param UnidadesRequestValidate $request Valores a insertar
     * @return JsonResponse
     */
    public function add(UnidadesRequestValidate $request) : JsonResponse
    {
        return $this->unidadRepository->new($request);
    }

    /**
     * Modificacion Completa - PUT
     *
     * @param UnidadesRequestValidate $request Todos los valores actualizables
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function edit(UnidadesRequestValidate $request, int $id) : JsonResponse
    {
        return $this->unidadRepository->update($request, $id);
    }

    /**
     * Modificacion Simple - PATCH
     *
     * @param UnidadesRequestValidate $request Valores a actualizar
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function set(UnidadesRequestValidate $request, int $id) : JsonResponse
    {
        return $this->unidadRepository->update($request, $id);
    }

    /**
     * Borrado de Registros - DELETE
     *
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        return $this->unidadRepository->delete($id);
    }
}
