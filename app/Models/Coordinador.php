<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinadores';
    protected $primaryKey = 'id_coordinador'; // ajusta si fuera diferente
    public $timestamps = false;

    protected $fillable = ['id_persona','codigo_de_acceso'];

    public function persona(){ return $this->belongsTo(Persona::class, 'id_persona', 'id_persona'); }
}
