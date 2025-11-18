<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VistaTablaPosiciones extends Model
{
    protected $table = 'vista_tabla_posiciones';
    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = false;
    protected $guarded = [];
}
