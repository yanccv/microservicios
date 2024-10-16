<?php

namespace App\Repositories;

// use App\Http\Requests\UnidadesRequestValidate;
// use App\Interfaces\UnidadesRepositoryInterface;
// use App\Models\Unidades;

use App\Http\Requests\DetalleFacturaRequestValidate;
use App\Http\Requests\FacturaRequestValidate;
use App\Interfaces\DetalleFacturaInterface;
use App\Interfaces\FacturaInterface;
use App\Interfaces\SalesInterface;
use App\Interfaces\SendMessagesInterface;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
// use Illuminate\Http\Request;

class SalesRepository implements SalesInterface
{

    private $factura, $detalleFactura, $sendMessageQueue;

    public function __construct(
        FacturaInterface $factura,
        DetalleFacturaInterface $detalleFactura,
        SendMessagesInterface $sendMessageQueue
    )
    {
        $this->factura = $factura;
        $this->detalleFactura = $detalleFactura;
        $this->sendMessageQueue = $sendMessageQueue;
    }

    /**
     * Buscar informacion de la venta donde Factura.id = $id
     *
     * @param [int] $id identificador de la venta
     * @return JsonResponse
     */
    public function find(int $id)
    {
        return $this->factura->find($id);

    }

    /**
     * Borrar venta
     *
     * @param integer $id identificador de la venta a borrar
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        $this->factura->delete($id);
    }


    /**
     * Listado de Ventas
     *
     * @return JsonResponse
     */
    public function all()
    {

    }


    /**
     * Procesa la venta
     * @param FacturaRequestValidate $factura
     * @param DetalleFacturaRequestValidate $detalleFactura
     *
     * @return JsonResponse
     */
    public function new(FacturaRequestValidate $saleFactura, DetalleFacturaRequestValidate $saleDetalleFactura) // : JsonResponse
    {
        return DB::transaction(function () use ($saleFactura, $saleDetalleFactura) {
            $newFactura = $this->factura->new($saleFactura);
            $this->detalleFactura->new($saleDetalleFactura, $newFactura->id);
            $this->sendMessageQueue->sendMessage($saleFactura->DetalleFactura, 'productsBySale', 'saleAdded', 'sale.Added');
            $this->sendMessageQueue->sendMessage($newFactura->only('id','usuarios_id','created_at'), 'userBySale', 'saleAdded', 'sale.Added');
            return JsonResponseCustom::sendJson([
                'status'    => true,
                'mensaje'   => 'Venta realizada con exito',
                'data'      => $saleDetalleFactura->all(),
                'httpCode'  => JsonResponseCustom::$CODE_CREATED_SUCCESS
            ]);
        });
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
