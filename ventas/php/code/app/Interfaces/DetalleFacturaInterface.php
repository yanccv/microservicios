<?php

namespace App\Interfaces;

use App\Http\Requests\DetalleFacturaRequestValidate;

interface DetalleFacturaInterface
{

    /**
     * Borrar registro del detallefactura
     *
     * @param integer $id identificador de la factura a borrar
     * @return boolean
     */
    public function delete(int $id);


    /**
     * Agrega nuevo registro del detallefactura
     *
     * @param DetalleFacturaRequestValidate $data array con los datos
     * @return boolean
     */
    public function new(DetalleFacturaRequestValidate $detalleFactura, int $idFactura);

    /**
     * Actualizacion de Registro
     *
     * @param DetalleFacturaRequestValidate $data array con los datos
     * @param integer $id identificador del registro del detallefactura a actualizar
     * @return boolean
     */
    public function update(DetalleFacturaRequestValidate $data, int $id);

}
