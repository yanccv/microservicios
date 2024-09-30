<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'detallefactura';
    protected $primaryKey = 'id';
    use HasFactory;

    /**
     * Atributos asignables
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'facturas_id',
        'productos_id',
        'producto',
        'precio',
        'cantidad'
    ];

    public function productos()
    {
        return $this->hasMany(
            Producto::class,
            'productos_id',
            'id'
        );
    }

    public function facturas()
    {
        return $this->belongsTo(
            Factura::class,
            'id',
            'facturas_id'
        );
    }
}
