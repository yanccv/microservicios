<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;
    protected $table = 'facturas';

        /**
     * atributos editables
     *
     * @var array <int, string>
     */
    public $timestamps = false;

    protected $fillable = [
        'id',
        'usuarios_id',
        'created_at',
        'fechaanulada',
        'estatus',
    ];

    public function usuario()
    {
        return $this->hasMany(
            Usuario::class,
            'usuarios_id',
            'id'
        );
    }
}
