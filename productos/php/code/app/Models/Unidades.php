<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    use HasFactory;

    protected $table = 'unidades';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'siglas', 'estatus'];

    protected $attributes = [
        'estatus' => 'Activo',
    ];

    public function productos()
    {
        return $this->hasMany(
            Producto::class,
            'unidades_id',
            'id',
        );
    }
}
