<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermisoEmpleado extends Model
{
    protected $table = 'permiso_empleados';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'incidencia',     // vacaciones | enfermedad | otros
        'motivo',
        'fecha_inicio',
        'fecha_fin',
        'imagen',         // path de la imagen
        'estado',         // solicitado | aprobado | rechazado
        'tenant_id'
    ];

    /**
     * Define la relación con el modelo de usuario (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

