<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';

    /**
     * atributos editables
     *
     * @var array <int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'clave',
        'lastsignin',
        'type',
        'estatus'
    ];
    // protected $casts = [
    //     'lastsignin' => 'datetime',
    // ];

    protected $attributes = [
        'estatus' => 1,
    ];

    /**
     * atributos ocultos.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'clave'
    ];

    /**
     * atributos que se castean.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'lastsignin' => 'datetime',
            'clave' => 'hashed',
        ];
    }

    public function facturas()
    {
        return $this->belongsTo(
            Facturas::class,
            'id',
            'usuarios_id'
        );
    }

}
