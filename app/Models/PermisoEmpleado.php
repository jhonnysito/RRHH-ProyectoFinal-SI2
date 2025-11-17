<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Incidencia;


class PermisoEmpleado extends Model
{
    use HasFactory;

    protected $table = 'permiso_empleados';

    protected $fillable = [
        'user_id',
        'incidencia_id',
        'fecha_inicio',
        'fecha_fin',
        'motivo',
        'archivo_adjunto',
        'estado',
        'tenant_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id');
    }
}
