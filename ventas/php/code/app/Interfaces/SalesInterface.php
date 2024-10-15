<?php

namespace App\Interfaces;

// use App\Http\Requests\UnidadesRequestValidate;

use App\Http\Requests\DetalleFacturaRequestValidate;
use App\Http\Requests\FacturaRequestValidate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface SalesInterface
{
    /**
     * Buscar informacion de la venta donde Factura.id = $id
     *
     * @param [int] $id identificador de la venta
     * @return JsonResponse
     */
    public function find(int $id);

    /**
     * Borrar venta
     *
     * @param integer $id identificador de la venta a borrar
     * @return JsonResponse
     */
    public function delete(int $id);


    /**
     * Listado de Ventas
     *
     * @return JsonResponse
     */
    public function all();



    /**
     * Agrega Venta
     * @param FacturaRequestValidate $factura
     * @param DetalleFacturaRequestValidate $detalleFactura
     *
     * @return [type]
     */
    public function new(FacturaRequestValidate $factura, DetalleFacturaRequestValidate $detalleFactura);
    // public function new2(FacturaRequestValidate $data, DetalleFacturaRequestValidate $data2);

    /**
     * Actualizacion de Registro
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @param integer $id identificador de la venta a actualizar
     * @return JsonResponse
     */
    public function update($data, int $id);

}
