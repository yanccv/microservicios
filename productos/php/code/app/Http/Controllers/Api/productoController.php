<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class productoController extends Controller
{
    /**
     * Validacion de los campos del modelo Producto
     */
    var $conditional = [
        'producto'      => 'required',
        'precio'        => 'nullable|numeric',
        'idcategoria'   => 'required'
    ];


    /**
     * Retorna Todos los Registros - GET
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list() : \Illuminate\Http\JsonResponse
    {
        return $this->allData(Producto::class);
    }

    /**
     * Obtener informacion de producto
     *
     * @param integer $id identificador del registro
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id) : \Illuminate\Http\JsonResponse
    {
        try {
            $producto = Producto::findOrFail($id);
            return $this->responseJson(200, '', $producto);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Producto no encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al actualizar el Producto', '', $th->getMessage());
        }
    }

    /**
     * Agregar Registro de Productos - POST
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) : \Illuminate\Http\JsonResponse
    {
        if (($validator = $this->validatorData($request, $this->conditional)) !== true) {
            return $validator;
        }
        return $this->addData(Producto::class, $request);
    }

    /**
     * Modificacion Completa - PUT
     *
     * @param Request $request Valores actualizables
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, int $id) : \Illuminate\Http\JsonResponse
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
        return $this->updateSingle(Producto::class, $id, $request);
    }


    /**
     * Borrado de Registros - DELETE
     *
     * @param integer $id identificador del registro a editar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        return $this->destroyGeneral(Producto::class, $id);
    }
}
