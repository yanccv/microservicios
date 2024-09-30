<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'id';
    /**
     * Atributos asignables
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'producto',
        'precio',
        'existencia',
        'estatus'
    ];

    /**
     * Valores por defecto
     *
     * @var array<string=string>
     */
    protected $attributes = [
        'estatus'       => 'Activo',
    ];

    public function detallefacturas()
    {
        return $this->belongsTo(
            DetalleFactura::class,
            'id',
            'productos_id'
        );
    }

}
