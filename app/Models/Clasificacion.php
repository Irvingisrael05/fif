<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    /**
     * Tabla asociada
     * @var string
     */
    protected $table = 'clasificacion';

    /**
     * Clave primaria
     * @var string
     */
    protected $primaryKey = 'id_clasificacion';

    /**
     * Deshabilitar timestamps (created_at/updated_at)
     * @var bool
     */
    public $timestamps = false;

    /**
     * Asignación masiva permitida
     * @var array<int, string>
     */
    protected $fillable = ["id_torneo", "id_equipo", "partidos_jugados", "goles_favor", "goles_contra", "diferencia_goles", "puntos"];
}
