<?php

namespace App\Interfaces;

// use App\Http\Requests\UnidadesRequestValidate;

use App\Http\Requests\FacturaRequestValidate;
use Illuminate\Http\JsonResponse;

interface FacturaInterface
{
    /**
     * Buscar informacion de la factura donde Factura.id = $id
     *
     * @param [int] $id identificador de la factura
     * @return JsonResponse
     */
    public function find(int $id);

    /**
     * Borrar venta
     *
     * @param integer $id identificador de la factura a borrar
     * @return JsonResponse
     */
    public function delete(int $id);


    /**
     * Listado de Facturas
     *
     * @return JsonResponse
     */
    public function all();


    /**
     * Agrega nueva Factura
     *
     * @param FacturaRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new(FacturaRequestValidate $factura);

    /**
     * Actualizacion de Registro
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @param integer $id identificador de la venta a actualizar
     * @return JsonResponse
     */
    public function update($data, int $id);

}
