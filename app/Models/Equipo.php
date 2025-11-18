<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'id_equipo';
    public $timestamps = false;

    protected $fillable = ['nombre', /* otros campos reales */];
}
