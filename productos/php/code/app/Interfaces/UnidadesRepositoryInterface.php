<?php

namespace App\Interfaces;

interface UnidadesRepositoryInterface
{
    public function find($id);
    public function all();
    public function create(array $data);
}
