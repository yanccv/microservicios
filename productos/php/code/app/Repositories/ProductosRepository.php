<?php

namespace App\Repositories;

use App\Http\Requests\ProductosRequestValidate;
use App\Interfaces\ProductosInterface;
use App\Interfaces\SendMessagesInterface;
use App\Models\Producto;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;

class ProductosRepository implements ProductosInterface
{
    private $jsonResponse;
    private $sendMessageQueue;

    public function __construct(
        JsonResponseCustom $jsonResponse,
        SendMessagesInterface $sendMessageQueue
    )
    {
        $this->jsonResponse = $jsonResponse;
        $this->sendMessageQueue = $sendMessageQueue;
    }

    /**
     * Obtiene informacion del producto con id = $id
     *
     * @param [int] $id identificador del registro
     * @return JsonResponse
     */
    public function find(int $id) : JsonResponse
    {
        return $this->jsonResponse::sendJson([
            'status'    => true,
            'data'      => Producto::findOrFail($id),
            'httpCode'  => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }

    /**
     * Listado de Productos
     *
     * @return JsonResponse
     */
    public function all() : JsonResponse
    {
        return $this->jsonResponse::sendJson([
            'status' => true,
            'data' => Producto::all(),
            'httpCode' => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }

    /**
     * Agrega nuevo producto
     *
     * @param ProductosRequestValidate $data array datos del registro a agregar
     * @return JsonResponse
     */
    public function new(ProductosRequestValidate $data) : JsonResponse
    {
        // return $this->jsonResponse::sendJson(['data' => $data->all(), 'httpCode' => 200]);
        $data->validated();
        $producto = Producto::create($data->all());
        $this->sendMessageQueue->sendMessage($producto->toArray(), 'productAdded', 'product.added');
        return $this->jsonResponse::sendJson([
            'status'    => true,
            'mensaje'   => 'Producto agregado',
            'data'      => $producto->toArray(),
            'httpCode'  => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }

    /**
     * Actualizacion de Registro
     *
     * @param ProductosRequestValidate $data array con los datos
     * @param integer $id identificador del registro a actualizar
     * @return JsonResponse
     */
    public function update(ProductosRequestValidate $data, int $id) : JsonResponse
    {
        $data->validated();
        $producto = Producto::findOrFail($id);
        $producto->fill($data->toArray());
        if (!$producto->isDirty()) {
            return $this->jsonResponse::sendJson([
                'status' => true,
                'mensaje' => 'Sin Cambios a Actualizar',
                'data' => $producto->toArray(),
                'httpCode' => $this->jsonResponse::$CODE_SUCCESS
            ]);
        }
        $producto->save();
        $this->sendMessageQueue->sendMessage($producto->toArray(), 'productUpdated', 'product.updated');
        return $this->jsonResponse::sendJson([
            'status' => true,
            'mensaje' => 'Registro actualizado',
            'data' => $producto->toArray(),
            'httpCode' => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }

    /**
     * Borrar Producto
     *
     * @param integer $id identificador del registro a borrar
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        $this->sendMessageQueue->sendMessage($id, 'productDeleted', 'product.deleted');
        return $this->jsonResponse::sendJson([
            'status' => true,
            'mensaje' => 'Registro eliminado',
            'httpCode' => $this->jsonResponse::$CODE_SUCCESS
        ]);
    }
}
