<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    protected $table = 'jugadores';
    protected $primaryKey = 'id_jugador';

    // Si tu tabla NO tiene created_at/updated_at
    public $timestamps = false;

    // 👈 Permite que Eloquent asigne estos campos
    protected $fillable = [
        'persona',     // <-- importantísimo
        'equipo',
        'dorsal',
        'posicion',
        'estado',
    ];

    // (Opcional) en lugar de $fillable puedes usar:
    // protected $guarded = ['id_jugador'];
}
