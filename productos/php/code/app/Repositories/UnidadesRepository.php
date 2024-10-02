<?php

namespace App\Repositories;

use App\Interfaces\UnidadesRepositoryInterface;
use App\Models\Unidades;

class UnidadesRepository implements UnidadesRepositoryInterface
{
    private $unidad;


    public function __construct(Unidades $unidad)
   {
       $this->unidad = $unidad;
   }

   public function find($id)
   {
       return $this->unidad->find($id);
   }

   public function all()
   {
       return $this->unidad->all();
   }

   public function create(array $data)
   {
       return $this->unidad->create($data);
   }
}
