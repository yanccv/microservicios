<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    /**
     * Atributos asignables
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idfactura',
        'idproducto',
        'producto',
        'precio',
        'cantidad',
        'impuesto',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
