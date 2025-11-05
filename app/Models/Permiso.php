<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'motivo',
        'tipo_permiso', // <-- ¡NUEVO CAMPO AÑADIDO!
        'fecha_inicio',
        'fecha_fin',
        'aprobado',
        'denegado',
    ];

    /**
     * Define la relación con el modelo de usuario (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}