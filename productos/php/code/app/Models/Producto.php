<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'producto',
        'precio',
        'estatus',
        'categorias_id',
        'unidades_id'
    ];
    protected $guarded = [];

    protected $attributes = [
        'estatus'       => 'Activo',
        'existencia'    => 0,
        'precio'        => 0
    ];

    public function setEstatusAttribute($value)
    {
        $this->attributes['estatus'] = trim($value);
    }

    public function setExistenciaAttribute($value)
    {
        $this->attributes['existencia'] = trim($value);
    }

    public function setPrecioAttribute($value = 0)
    {
        $this->attributes['precio'] = trim($value);
    }


    // Definicion de las claves Foraneas
    public function categoria()
    {
        return $this->belongsTo(
            Categoria::class,
            'categorias_id',
            'id'
        );
    }
    public function unidad()
    {
        return $this->belongsTo(
            Unidades::class,
            'unidades_id',
            'id',
        );
    }
}
