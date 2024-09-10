<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['categoria', 'estatus'];

    protected $attributes = [
        'estatus' => 1,
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);  

    }
}
