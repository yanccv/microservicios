<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
#use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator;

Validator::extend('unique_email', function ($attribute, $value, $parameters, $validator) {
    return Usuario::where('email', $value)
    ->where('id', '!=', $parameters[0])
    ->doesntExist();
});

class usuarioController extends Controller
{
    public function index()
    {
        $data = Usuario::all();
        if ($data->isEmpty()) {
            unset($data);
            $data = [
                'message' => 'No se encontraron usuarios',
                'status' => 404
            ];
        } else {
            $data = [
                'usuarios' => $data,
                'status' => 200
            ];
        }
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|unique:usuarios|email',
            'clave' => 'required',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'clave' => $request->clave,
            'type' => $request->type,
            'lastsignin' => null
        ]);

        if (!$usuario) {
            $data = [
                'message' => 'Error al crear el Usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Usuario Creado',
            'usuario' => $usuario,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function updatefull(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique_email:' . $id,
            'clave' => 'required',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        try {
            $user = Usuario::findOrFail($id);
            $user->update($request->all());
            return response()->json(['success' => true, 'message' => 'Actualización Exitosa'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response()->json(['success' => false, 'message' => 'Id No encontrado'], 404);
        }
    }

    public function updatePartial(Request $request, int $id)
    {

    }

    public function destroy(int $id)
    {
        try {
            $user = Usuario::findOrFail($id);
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Registro eliminado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response()->json(['success' => false, 'message' => 'Id No encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el registro'], 500);
        }
    }
}
