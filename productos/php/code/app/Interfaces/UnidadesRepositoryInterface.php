<?php

namespace App\Interfaces;

use App\Http\Requests\UnidadesRequestValidate;
use Illuminate\Http\JsonResponse;

interface UnidadesRepositoryInterface
{
    /**
     * Buscar informacion de la unidad del id pasado
     *
     * @param [int] $id
     * @return JsonResponse
     */
    public function find(int $id);

    /**
     * Borrar unidad
     *
     * @param integer $id identificador de la unidad a borrar
     * @return JsonResponse
     */
    public function delete(int $id);


    /**
     * Listado de Unidades
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
    public function new(UnidadesRequestValidate $data);

    /**
     * Actualizacion de Registro
     *
     * @param UnidadesRequestValidate $data array con los datos
     * @param integer $id identificador de la unidad a actualizar
     * @return JsonResponse
     */
    public function update(UnidadesRequestValidate $data, int $id);

}
