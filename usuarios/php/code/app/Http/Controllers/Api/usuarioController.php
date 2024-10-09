<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuariosRequestValidate;
use App\Interfaces\UsuariosInterface;
use Illuminate\Http\JsonResponse;


class usuarioController extends Controller
{
    private $usuariosRepository;

    public function __construct(UsuariosInterface $usuariosRepository)
    {
        $this->usuariosRepository = $usuariosRepository;
    }


    /**
     * Procesa la peticion para obtener todos los usuarios - GET
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()  : JsonResponse
    {
        return $this->usuariosRepository->all();
    }

    /**
     * procesa la peticion para obtener informacion de un usuario
     *
     * @param integer $id identificador del registro
     * @return JsonResponse
     */
    public function getUsuario(int $id) : JsonResponse
    {
        return $this->usuariosRepository->find($id);
    }

    /**
     * Procesa la peticion de agregar Usuario - POST
     *
     * @param UsuariosRequestValidate $request Valores a insertar
     * @return JsonResponse
     */
    public function add(UsuariosRequestValidate $request) : JsonResponse
    {
        return $this->usuariosRepository->new($request);
    }

    /**
     * Procesa la peticion de una modificacion Completa - PUT
     *
     * @param UsuariosRequestValidate $request Valores actualizables
     * @param integer $id identificador del registro a editar
     * @return JsonResponse
     */
    public function edit(UsuariosRequestValidate $request, int $id) : JsonResponse
    {
        return $this->usuariosRepository->update($request, $id);
    }

    /**
     * Procesa la peticion de una modificacion Simple - PATCH
     *
     * @param UsuariosRequestValidate $request Valores a actualizar
     * @param integer $id identificador del registro a editar
     * @return JsonResponse responseJson()
     */
    public function set(UsuariosRequestValidate $request, int $id) : JsonResponse
    {
        return $this->usuariosRepository->update($request, $id);
    }

    /**
     * Procesa la peticion para eliminar un usuario
     * @param int $id identificador del registro a eliminar
     *
     * @return JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        return $this->usuariosRepository->delete($id);
    }
}
