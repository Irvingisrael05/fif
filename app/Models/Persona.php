<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    public $timestamps = false;

    protected $fillable = [
        'nombre','apaterno','amaterno',
        'fecha_de_nacimiento','correo','id_localidad','curp',
        'password','tipo_de_usuario'
    ];

    // Relaciones útiles (opcional)
    public function localidad(){ return $this->belongsTo(Localidad::class, 'id_localidad', 'id_localidad'); }
    public function coordinador(){ return $this->hasOne(Coordinador::class, 'id_persona', 'id_persona'); }
    public function arbitro(){ return $this->hasOne(Arbitro::class, 'id_persona', 'id_persona'); }
    public function jugador(){ return $this->hasOne(Jugador::class, 'id_persona', 'id_persona'); }
}
