<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    /**
     * Tabla asociada
     * @var string
     */
    protected $table = 'municipios';

    /**
     * Clave primaria
     * @var string
     */
    protected $primaryKey = 'id_municipio';

    /**
     * Deshabilitar timestamps (created_at/updated_at)
     * @var bool
     */
    public $timestamps = false;

    /**
     * Asignación masiva permitida
     * @var array<int, string>
     */
    protected $fillable = ["nombre", "estado"];
}
