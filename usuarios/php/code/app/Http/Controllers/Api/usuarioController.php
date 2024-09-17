<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

    // TODO
    // Rectorizar Code a como esta el midro de productos

Validator::extend('unique_email', function ($attribute, $value, $parameters, $validator) {
    return Usuario::where('email', $value)
    ->where('id', '!=', $parameters[0])
    ->doesntExist();
});

class usuarioController extends Controller
{
    /**
     * Validacion de los campos del modelo Usuario
     */
    var $conditional = [
        'nombre' => 'required',
        'apellido' => 'required',
        'email' => 'required|email|unique_email:',
        'clave' => 'required',
        'type' => 'required'
    ];


    /**
     * Retorna Todos los Registros - GET
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = Usuario::all();
        if ($data->isEmpty()) {
            return $this->responseJson(40, 'No se encontraron usuarios');
        }
        return $this->responseJson(200, '', $data);
    }

    /**
     * Obtener informacion de usuario
     *
     * @param integer $id identificador del registro
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id)
    {
        try {
            $user = Usuario::findOrFail($id);
            return $this->responseJson(200, '', $user);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $mnfe) {
            return $this->responseJson(200, 'Registro no encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(200, 'Registro no encontrado', '', $th->getMessage());
        }
    }

    /**
     * Agregar Usuario - POST
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        if (($validator = $this->validatorData($request->all(), $this->conditional)) !== true) {
            return $validator;
        }
        return $this->addData(Usuario::class, $request);
    }

    /**
     * Modificacion Completa - PUT
     *
     * @param Request $request Valores actualizables
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, int $id)
    {
        $condition = $this->conditional;
        $condition['email'] = 'required|email|unique_email:' . $id;
        if (($validator = $this->validatorData($request->all(), $condition)) !== true) {
            return $validator;
        }
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->update($request->all());
            return $this->responseJson(200, 'Actualizacion Exitosa', $usuario);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Registro no encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar', '', $th->getMessage());
        }
    }

    public function updatePartial(Request $request, int $id)
    {

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
        $conditional = $this->conditional;
        $conditional['email'] = 'required|email|unique_email:' . $id;
        $conditional = array_intersect_key($conditional, $request->all());
        if (($validator = $this->validatorData($request, $conditional)) !== true) {
            return $validator;
        }
        return $this->updateSingle(Usuario::class, $id, $request);
    }

    public function destroy(int $id)
    {
        return $this->destroyGeneral(Usuario::class, $id);
    }
}
