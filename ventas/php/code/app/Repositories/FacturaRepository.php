<?php

namespace App\Repositories;

// use App\Http\Requests\UnidadesRequestValidate;
// use App\Interfaces\UnidadesRepositoryInterface;
// use App\Models\Unidades;

use App\Http\Requests\FacturaRequestValidate;
use App\Interfaces\DetalleFacturaInterface;
use App\Interfaces\FacturaInterface;
use App\Models\Factura;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;

class FacturaRepository implements FacturaInterface
{
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
     * Agrega nueva unidad
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new(FacturaRequestValidate $data)
    {
        return Factura::create($data->validated());
        // $this->factura->delete($data['factura_id']);
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
