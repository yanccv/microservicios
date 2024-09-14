<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;

class usuarioController extends Controller
{
    /**
     * Obtener informacion de usuario
     *
     * @param integer $id identificador del registro
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id) : \Illuminate\Http\JsonResponse
    {
        try {
            $usuario = Usuario::findOrFail($id);
            return $this->responseJson(200, '', $usuario);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Usuario no encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al no se obtuvieron datos', '', $th->getMessage());
        }
    }

}
