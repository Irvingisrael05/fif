<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    /**
     * Tabla asociada
     * @var string
     */
    protected $table = 'logos';

    /**
     * Clave primaria
     * @var string
     */
    protected $primaryKey = 'id_logo';

    /**
     * Deshabilitar timestamps (created_at/updated_at)
     * @var bool
     */
    public $timestamps = false;

    /**
     * Asignación masiva permitida
     * @var array<int, string>
     */
    protected $fillable = ["Url", "estado"];
}
