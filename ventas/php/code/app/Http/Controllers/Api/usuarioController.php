<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;

class usuarioController extends Controller
{
    var $conditional = [
        'nombre' => 'required',
        'apellido' => 'required',
        'email' => 'required|unique:usuarios|email',
        'clave' => 'required',
        'type' => 'required'
    ];
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


    /**
     * Agregar Usuario - POST
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) : \Illuminate\Http\JsonResponse
    {
        return $this->addData(Usuario::class, $request);
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
        return $this->updateSingle(Usuario::class, $id, $request);
    }

    /**
     * Borrado de Registros - DELETE
     *
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        return $this->destroyGeneral(Usuario::class, $id);
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function add(Request $request) : \Illuminate\Http\JsonResponse
    // {

    //     // $this->validatorData($request, )
    //     $validator = Validator::make($request->all(), [
    //         'nombre' => 'required',
    //         'apellido' => 'required',
    //         'email' => 'required|unique:usuarios|email',
    //         'clave' => 'required',
    //         'type' => 'required'
    //     ]);
    //     if ($validator->fails()) {
    //         $data = [
    //             'message' => 'Error en la validación de los datos',
    //             'errors' => $validator->errors(),
    //             'status' => 400
    //         ];
    //         return response()->json($data, 400);
    //     }
    //     $usuario = Usuario::create([
    //         'nombre' => $request->nombre,
    //         'apellido' => $request->apellido,
    //         'email' => $request->email,
    //         'clave' => $request->clave,
    //         'type' => $request->type,
    //         'lastsignin' => null
    //     ]);

    //     if (!$usuario) {
    //         $data = [
    //             'message' => 'Error al crear el Usuario',
    //             'status' => 500
    //         ];
    //         return response()->json($data, 500);
    //     }

    //     $data = [
    //         'message' => 'Usuario Creado',
    //         'usuario' => $usuario,
    //         'status' => 201
    //     ];
    //     return response()->json($data, 201);
    // }
}
