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
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SalesRepository implements SalesInterface
{

    private $factura, $detalleFactura;

    public function __construct(
        FacturaInterface $factura,
        DetalleFacturaInterface $detalleFactura
    )
    {
        $this->factura = $factura;
        $this->detalleFactura = $detalleFactura;
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
     * Agrega nueva venta
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new($data) : JsonResponse
    {

        return DB::transaction(function () use ($data) {
            $dataFactura = new FacturaRequestValidate(['usuario_id' => $data['usuario_id']]);
            $factura = $this->factura->new($dataFactura);

            $dataDetalleFactura = [];
            foreach ($data['detalles'] as $detalleProducto) {
                $productoDetalle['facturas_id'] = $factura->id;
                $dataDetalleFactura[] = $this->detalleFactura->new(new DetalleFacturaRequestValidate($detalleProducto));
            }
            $dataResponse = $factura;
            $dataResponse['detalleFactura'] = $dataDetalleFactura;

            return JsonResponseCustom::sendJson([
                'status'    => true,
                'mensaje'   => 'Registro agregado',
                'data'      => $dataResponse,
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
