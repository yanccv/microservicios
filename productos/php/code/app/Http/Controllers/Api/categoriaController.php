<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class categoriaController extends Controller
{
    var $conditional = [
        'categoria'      => 'required'
    ];

    /**
     * listado de productos
     *
     * @return Listado de Categorias
     */
    public function list()
    {
        $data = Categoria::all();
        if ($data->isEmpty()) {
            return $this->responseJson(200, 'No se encontraron Categorias');
        } else {
            return $this->responseJson(200, '', $data);
        }
    }


    /**
     * Agrega categoria a la bd
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
            $categoria = Categoria::create([
                'categoria' => $request->categoria
            ]);
            return $this->responseJson(201, 'Categoria Agregada', $categoria);
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al crear la Categoria', '', $th->getMessage());
        }

    }

    public function edit(Request $request, int $id)
    {
        if (($validator = $this->validatorData($request, $this->conditional)) !== true) {
            return $validator;
        }
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->update([
                'categoria' => $request->categoria,
            ]);
            return $this->responseJson(200, 'Actualizacion Exitosa', $categoria);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Categoria no encontrada');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar la Categoria', '', $th->getMessage());
        }
    }

    public function destroy(int $id)
    {
        return $this->destroy(Categoria::class, $id);
    }
}
