<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class productoController extends Controller
{
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
            return $this->responseJson(500, 'Error al no se obtuvieron datos', '', $th->getMessage());
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
        return $this->addData(Producto::class, $request);
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
