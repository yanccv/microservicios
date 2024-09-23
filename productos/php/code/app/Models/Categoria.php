<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'estatus'];

    protected $attributes = [
        'estatus' => 'Activo',
    ];

    public function productos()
    {
        return $this->hasMany(
            Producto::class,
            'categorias_id',
            'id'
        );
    }
}
