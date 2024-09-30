<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'facturas';
    protected $primaryKey = 'id';
    /**
     * Atributos asignables
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuarios_id',
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

    public function detalles()
    {
        return $this->hasMany(
            DetalleFactura::class,
            'facturas_id',
            'id'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id',
            'id'
        );
    }
}
