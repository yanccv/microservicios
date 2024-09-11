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

    /**
     * listado de productos
     *
     * @return Listado de Productos
     */
    public function list()
    {
        $data = Producto::all();
        if ($data->isEmpty()) {
            return $this->responseJson(200, 'No se encontraron Productos');
        } else {
            return $this->responseJson(200, '', $data);
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
            return $this->responseJson(201, 'Producto Agregado', $producto);
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al crear el Producto', '', $th->getMessage());
        }

    }

    public function edit(Request $request, int $id)
    {
        if (($validator = $this->validatorData($request, $this->conditional)) !== true) {
            return $validator;
        }
        try {
            $producto = Producto::findOrFail($id);
            $producto->update([
                'producto' => $request->producto,
                'precio' => $request->precio,
                'idcategoria' => $request->idcategoria,
            ]);
            return $this->responseJson(200, 'Actualizacion Exitosa', $producto);
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
        return $this->destroy(Producto::class, $id);
    }
}
