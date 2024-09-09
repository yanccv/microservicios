<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'clave',
        'lastsignin',
        'type',
        'estatus'
    ];
    protected $casts = [
        'lastsignin' => 'datetime',
    ];
    protected $attributes = [
        'estatus' => 1,
    ];

}
