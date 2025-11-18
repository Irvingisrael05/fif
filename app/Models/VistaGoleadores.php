<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VistaGoleadores extends Model
{
    protected $table = 'vista_goleadores';
    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = false;
    protected $guarded = [];
}
