<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    /**
     * Atributos asignables
     *
     * @var array<string>
     */
    protected $fillable = [
        'producto',
        'unidad',
        'precio',
        'existencia',
        'impuesto',
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

}
