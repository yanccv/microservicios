<?php

namespace App\Interfaces;

use App\Http\Requests\unidadesRequestValidate;
use App\Models\Unidades;

interface UnidadesRepositoryInterface
{
    public function find($id);
    public function all();
    public function new(unidadesRequestValidate $data);
    public function update(unidadesRequestValidate $data, Unidades $unidad);

}
