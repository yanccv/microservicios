<?php

namespace App\Repositories;

// use App\Http\Requests\UnidadesRequestValidate;
// use App\Interfaces\UnidadesRepositoryInterface;
// use App\Models\Unidades;

use App\Http\Requests\FacturaRequestValidate;
use App\Interfaces\DetalleFacturaInterface;
use App\Interfaces\FacturaInterface;
use App\Models\Factura;
use App\Models\Usuario;
use App\Utilities\JsonResponseCustom;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

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
        return Factura::with('detalles')->find($id);
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
        return Factura::with('detalles')->get();
    }


    /**
     * Agrega nueva factura
     *
     * @param FacturaRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new(FacturaRequestValidate $facturaForm)
    {
        $facturaForm->validated();
        Usuario::findOrFail($facturaForm->Factura['usuarios_id']);
        return  Factura::create($facturaForm->Factura);
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
