<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'producto',
        'precio',
        'estatus',
        'idcategoria'
    ];

    protected $attributes = [
        'estatus' => 1,
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
