<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    use HasFactory;

    protected $fillable = ['unidad', 'siglas', 'estatus'];

    protected $attributes = [
        'estatus' => 'Activo',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
