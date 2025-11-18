<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    protected $table = 'canchas';
    protected $primaryKey = 'id_cancha';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'localidad',   // FK a localidades.id_localidad
        'direccion',
        'capacidad',
        'telefono',
        'condiciones',
    ];

    public function localidadRel()
    {
        return $this->belongsTo(Localidad::class, 'localidad', 'id_localidad');
    }
}
