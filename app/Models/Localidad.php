<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidades';
    protected $primaryKey = 'id_localidad';
    public $timestamps = false;

    protected $fillable = [
        'comunidad'
    ];
}
