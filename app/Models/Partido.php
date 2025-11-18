<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $table = 'partido';
    protected $primaryKey = 'id_partido';
    public $timestamps = false;

    protected $fillable = [
        'id_torneo','jornada','fecha','hora',
        'equipo_local','equipo_visitante',
        'id_arbitro','id_cancha','estado_partido',
    ];

    // Relaciones “oficiales”
    public function torneo()
    {
        return $this->belongsTo(Torneo::class, 'id_torneo', 'id_torneo');
    }

    public function cancha()
    {
        return $this->belongsTo(Cancha::class, 'id_cancha', 'id_cancha');
    }

    public function arbitro()
    {
        return $this->belongsTo(Arbitro::class, 'id_arbitro', 'id_arbitro');
    }

    public function equipoLocal()
    {
        return $this->belongsTo(Equipo::class, 'equipo_local', 'id_equipo');
    }

    public function equipoVisitante()
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante', 'id_equipo');
    }

    // ===== Alias para compatibilidad con código existente =====
    public function local()       // <- alias de equipoLocal
    {
        return $this->equipoLocal();
    }

    public function visitante()   // <- alias de equipoVisitante
    {
        return $this->equipoVisitante();
    }
}
