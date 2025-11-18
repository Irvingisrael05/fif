<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arbitro extends Model
{
    protected $table = 'arbitros';
    protected $primaryKey = 'id_arbitro';
    public $timestamps = false;

    // ⚠️ Asegúrate de incluir 'persona' y 'estado'
    protected $fillable = [
        'persona',
        'licencia',
        'anios_experiencia',
        'vigencia_licencia',
        'estado',
    ];
}
