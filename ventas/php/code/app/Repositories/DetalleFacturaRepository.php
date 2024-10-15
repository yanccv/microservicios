<?php

namespace App\Repositories;

// use App\Http\Requests\UnidadesRequestValidate;
// use App\Interfaces\UnidadesRepositoryInterface;
// use App\Models\Unidades;

use App\Http\Requests\DetalleFacturaRequestValidate;
use App\Interfaces\DetalleFacturaInterface;
use App\Models\DetalleFactura;
use App\Models\Producto;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\throwException;

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
     * @param int $facturas_id array con los datos
     * @return JsonResponse
     */
    public function new(DetalleFacturaRequestValidate $sale, int $idFactura)
    {
        foreach ($sale->DetalleFactura as $detalleFactura) {
            $detalleFactura['facturas_id'] = $idFactura;
            $productoInfo = Producto::where('estatus', 'Activo')->findOrFail($detalleFactura['productos_id']);

            if ($productoInfo->existencia < $detalleFactura['cantidad']) {
                throw new Exception("Producto: {$productoInfo->producto} solo hay [{$productoInfo->existencia}] y requieres {$detalleFactura['cantidad']}");
            }

            $detalleFactura = array_merge($productoInfo->toArray(), $detalleFactura);
            DetalleFactura::create($detalleFactura);

            $productoInfo->existencia -=$detalleFactura['cantidad'];
            $productoInfo->save();
        }
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
