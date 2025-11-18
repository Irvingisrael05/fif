<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Torneo extends Model
{
    protected $table = 'torneos';
    protected $primaryKey = 'id_torneo';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'temporada', 'fecha_inicio', 'fecha_fin', 'localidad', 'descripcion'
    ];

    // Para poder usar $torneo->estado en Blade
    protected $appends = ['estado'];

    // Relación para mostrar el nombre de la localidad
    public function localidadRel()
    {
        return $this->belongsTo(\App\Models\Localidad::class, 'localidad', 'id_localidad');
    }

    // Atributo calculado: Activo / Finalizado / Planificado
    public function getEstadoAttribute(): string
    {
        $hoy = Carbon::today();
        if (Carbon::parse($this->fecha_inicio)->gt($hoy)) {
            return 'Planificado';
        }
        if (Carbon::parse($this->fecha_fin)->lt($hoy)) {
            return 'Finalizado';
        }
        return 'Activo';
    }

    // Scope para filtrar por estado desde el controlador
    public function scopeFiltrarPorEstado($query, ?string $estado)
    {
        $hoy = Carbon::today();

        switch ($estado) {
            case 'activos':
                return $query->whereDate('fecha_inicio', '<=', $hoy)
                    ->whereDate('fecha_fin', '>=', $hoy);
            case 'finalizados':
                return $query->whereDate('fecha_fin', '<', $hoy);
            case 'planificados':
                return $query->whereDate('fecha_inicio', '>', $hoy);
            default:
                return $query; // todos
        }
    }
}
