<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriasRequestValidate;
use App\Interfaces\CategoriasBaseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class categoriaController extends Controller
{

    private $categoriaRepository;

    public function __construct(CategoriasBaseInterface $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * listado de categorias - GET
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list() : JsonResponse
    {
        return $this->categoriaRepository->all();
    }

    /**
     * Obtener  Categorias - GET
     *
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function getUnidad(int $id) : JsonResponse
    {
        return $this->categoriaRepository->find($id);

    }

    /**
     * Agregar Registro de Categorias - POST
     *
     * @param Request $request Valores a insertar
     * @return JsonResponse
     */
    public function add(CategoriasRequestValidate $request) : JsonResponse
    {
        return $this->categoriaRepository->new($request);
    }

    /**
     * Modificacion Completa - PUT
     *
     * @param Request $request Todos los valores actualizables
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function edit(CategoriasRequestValidate $request, int $id) : JsonResponse
    {
        return $this->categoriaRepository->update($request, $id);
    }


    /**
     * Modificacion Simple - PATCH
     *
     * @param Request $request Valores a actualizar
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function set(CategoriasRequestValidate $request, int $id) : JsonResponse
    {
        return $this->categoriaRepository->update($request, $id);
    }

    /**
     * Borrado de Registros - DELETE
     *
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        return $this->categoriaRepository->delete($id);
    }
}
