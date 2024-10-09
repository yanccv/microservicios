<?php

namespace App\Repositories;

use App\Http\Requests\UsuariosRequestValidate;
use App\Interfaces\SendMessagesInterface;
use App\Interfaces\UsuariosInterface;
use App\Models\Usuario;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;

class UsuariosRepository implements UsuariosInterface
{
    private $jsonResponse;
    private $sendMessageQueue;

    public function __construct(
        JsonResponseCustom $jsonResponse,
        SendMessagesInterface $sendMessageQueue
    )
    {
        $this->jsonResponse     = $jsonResponse;
        $this->sendMessageQueue = $sendMessageQueue;
    }

    /**
     * Obtiene la informacion del usuario con id = $id
     *
     * @param [int] $id identificador del registro
     * @return JsonResponse
     */
    public function find(int $id) : JsonResponse
    {
        return $this->jsonResponse::sendJson([
            'status'    => true,
            'data'      => Usuario::findOrFail($id),
            'httpCode'  => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }

    /**
     * Obtiene todos los usuarios
     *
     * @return JsonResponse
     */
    public function all() : JsonResponse
    {
        return $this->jsonResponse::sendJson([
            'status' => true,
            'data' => Usuario::all(),
            'httpCode' => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }

    /**
     * Agrega nuevo usuario
     *
     * @param UsuariosRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new(UsuariosRequestValidate $data) : JsonResponse
    {
        // dd($data->validated());
        $usuario = Usuario::create($data->validated());
        $this->sendMessageQueue->sendMessage($usuario->toArray(), 'usersAdded', 'users.added');
        return $this->jsonResponse::sendJson([
            'status'    => true,
            'mensaje'   => 'Registro agregado',
            'data'      => $usuario->toArray(),
            'httpCode'  => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }

    /**
     * Actualizacion de Registro
     *
     * @param UsuariosRequestValidate $data array con los datos
     * @param integer $id identificador del registro a actualizar
     * @return JsonResponse
     */
    public function update(UsuariosRequestValidate $data, int $id) : JsonResponse
    {
        $data->validated();
        $usuario = Usuario::findOrFail($id);
        $usuario->fill($data->toArray());
        if (!$usuario->isDirty()) {
            return $this->jsonResponse::sendJson([
                'status' => true,
                'mensaje' => 'Sin Cambios a Actualizar',
                'data' => $usuario->toArray(),
                'httpCode' => $this->jsonResponse::$CODE_SUCCESS
            ]);
        }
        $usuario->save();
        $this->sendMessageQueue->sendMessage($usuario->toArray(), 'usersUpdated', 'users.updated');
        return $this->jsonResponse::sendJson([
            'status' => true,
            'mensaje' => 'Registro actualizado',
            'data' => $usuario->toArray(),
            'httpCode' => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }

    /**
     * Borrar usuario
     *
     * @param integer $id identificador del usuario a borrar
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        $usuarios = Usuario::findOrFail($id);
        $usuarios->delete();
        $this->sendMessageQueue->sendMessage($id, 'usersDeleted', 'users.deleted');
        return $this->jsonResponse::sendJson([
            'status' => true,
            'mensaje' => 'Registro eliminado',
            'httpCode' => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }
}
