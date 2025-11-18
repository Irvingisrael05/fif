<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignaPartido extends Model
{
    /**
     * Tabla asociada
     * @var string
     */
    protected $table = 'asigna_partido';

    /**
     * Clave primaria
     * @var string
     */
    protected $primaryKey = 'id_asigna';

    /**
     * Deshabilitar timestamps (created_at/updated_at)
     * @var bool
     */
    public $timestamps = false;

    /**
     * Asignación masiva permitida
     * @var array<int, string>
     */
    protected $fillable = ["id_partido", "goles_local", "goles_visitante", "puntos_local", "puntos_visitante"];
}
