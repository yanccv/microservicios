<?php

namespace App\Repositories;

// use App\Http\Requests\UnidadesRequestValidate;
// use App\Interfaces\UnidadesRepositoryInterface;
// use App\Models\Unidades;

use App\Http\Requests\DetalleFacturaRequestValidate;
use App\Interfaces\DetalleFacturaInterface;
use App\Models\DetalleFactura;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;

class DetalleFacturaRepository implements DetalleFacturaInterface
{

    /**
     * Borrar venta
     *
     * @param integer $id identificador de la venta a borrar
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        $detalleFacturaProducto = DetalleFactura::findOrFails($id);
        $detalleFacturaProducto->delete();
        return true;
    }


    /**
     * Agrega nuevo registro en detalle factura
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new(DetalleFacturaRequestValidate $data)
    {
        $data->validated();
        $producto = Producto::findOrFail($data['productos_id']);
        $data = array_merge($producto->toArray(), $data);
        $detalleFactura = new DetalleFactura();
        $detalleFactura->fill($data);
        $detalleFactura->save();
        return $detalleFactura->toArray();
    }

    /**
     * Actualizacion de Registro
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @param integer $id identificador de la venta a actualizar
     * @return JsonResponse
     */
    public function update($data, int $id)
    {

    }


}
