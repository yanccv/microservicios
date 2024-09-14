<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    /**
     * Atributos asignables
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idusuario',
        'fechaanulada',
        'estatus',
    ];

    /**
     * Valores por defecto
     *
     * @var array<string=string>
     */
    protected $attributes = [
        'estatus'       => 'Activo',
    ];

    public function detalleFactura()
    {
        return $this->hasMany(DetalleFactura::class);
    }
}
