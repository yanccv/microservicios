<?php

namespace App\Interfaces;

use App\Http\Requests\DetalleFacturaRequestValidate;

use Illuminate\Http\JsonResponse;

interface DetalleFacturaInterface
{
    /**
     * Buscar informacion del detallefactura donde detalleFactura.id = $id
     *
     * @param [int] $id identificador del detallefactura
     * @return JsonResponse
     */
    public function find(int $id);

    /**
     * Borrar registro del detallefactura
     *
     * @param integer $id identificador de la factura a borrar
     * @return JsonResponse
     */
    public function delete(int $id);


    // /**
    //  * Listado del deFacturas
    //  *
    //  * @return JsonResponse
    //  */
    // public function all();


    /**
     * Agrega nuevo registro del detallefactura
     *
     * @param DetalleFacturaRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new($data);

    /**
     * Actualizacion de Registro
     *
     * @param DetalleFacturaRequestValidate $data array con los datos
     * @param integer $id identificador del registro del detallefactura a actualizar
     * @return JsonResponse
     */
    public function update($data, int $id);

}
