<?php

namespace App\Interfaces;

// use App\Http\Requests\UnidadesRequestValidate;
use Illuminate\Http\JsonResponse;

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
     * Agrega nueva unidad
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new($data);

    /**
     * Actualizacion de Registro
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @param integer $id identificador de la venta a actualizar
     * @return JsonResponse
     */
    public function update($data, int $id);

}
