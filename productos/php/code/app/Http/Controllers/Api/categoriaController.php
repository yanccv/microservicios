<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class categoriaController extends Controller
{
    /**
     * Validacion de los campos del modelo Categoria
     */
    var $conditional = [
        'categoria'      => 'required'
    ];

    /**
     * listado de categorias - GET
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list() : \Illuminate\Http\JsonResponse
    {
        return $this->allData(Categoria::class);
    }


    /**
     * Agregar Registro de Categorias - POST
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) : \Illuminate\Http\JsonResponse
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

    /**
     * Modificacion Completa - PUT
     *
     * @param Request $request Todos los valores actualizables
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, int $id) : \Illuminate\Http\JsonResponse
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

    /**
     * Modificacion Simple - PATCH
     *
     * @param Request $request Valores a actualizar
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse responseJson()
     */
    public function set(Request $request, int $id) : \Illuminate\Http\JsonResponse
    {
        $conditional = array_intersect_key($this->conditional, $request->all());
        if (($validator = $this->validatorData($request, $conditional)) !== true) {
            return $validator;
        }
        return $this->updateSingle(Categoria::class, $id, $request);
    }

    /**
     * Borrado de Registros - DELETE
     *
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        return $this->destroyGeneral(Categoria::class, $id);
    }
}
