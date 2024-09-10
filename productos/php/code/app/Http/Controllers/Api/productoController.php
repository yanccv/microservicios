<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class productoController extends Controller
{
    var $conditional = [
        'producto'      => 'required',
        'precio'        => 'nullable|numeric',
        'idcategoria'   => 'required'
    ];
    public function index()
    {
        $data = Producto::all();
        if ($data->isEmpty()) {
            $this->responseJson(200, 'No se encontraron Productos');
        } else {
            $this->responseJson(200, '', $data);
        }
    }

    /**
     * Agrega a la bD
     *
     * @param Request formulario con los datos
     * @return responseJson
     */
    public function add(Request $request)
    {
        if (($validator = $this->validatorData($request, $this->conditional)) !== true) {
            return $validator;
        }
        try {
            $producto = Producto::create([
                'producto' => $request->producto,
                'precio' => $request->precio,
                'idcategoria' => $request->idcategoria,
                'existencia' => 0
            ]);
            $this->responseJson(201, 'Producto Agregado', $producto);
        } catch (\Throwable $th) {
            $this->responseJson(500, 'Error al crear el Producto', '', $th->getMessage());
        }

    }

    public function edit(Request $request, int $id)
    {
        if (($validator = $this->validatorData($request, $this->conditional)) !== true) {
            return $validator;
        }
        try {
            $producto = Usuario::findOrFail($id);
            $producto->update([
                'producto' => $request->producto,
                'precio' => $request->precio,
                'idcategoria' => $request->idcategoria,
            ]);
            $this->responseJson(200, 'Actualizacion Exitosa', $producto);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Producto no encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar el Producto', '', $th->getMessage());
        }
    }

    public function set()
    {

    }
    public function destroy(int $id)
    {
        return $this->destroy('Producto', $id);
        // try {
        //     $user = Usuario::findOrFail($id);
        //     $user->delete();
        //     return response()->json(['success' => true, 'message' => 'Registro eliminado'], 200);
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
        //     return response()->json(['success' => false, 'message' => 'Registro No encontrado'], 404);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Error al eliminar el registro'], 500);
        // }
    }
}
