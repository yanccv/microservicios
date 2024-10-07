<?php

namespace App\Interfaces;

use App\Http\Requests\unidadesRequestValidate;
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
     * @param unidadesRequestValidate $data array con los datos
     * @return JsonResponse
     */
    public function new(unidadesRequestValidate $data);

    /**
     * Actualizacion de Registro
     *
     * @param unidadesRequestValidate $data array con los datos
     * @param integer $id identificador de la unidad a actualizar
     * @return JsonResponse
     */
    public function update(unidadesRequestValidate $data, int $id);

}
