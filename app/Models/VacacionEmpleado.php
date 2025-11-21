<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacacionEmpleado extends Model
{
    protected $table = 'vacaciones_empleado';

    protected $fillable = [
        'tenant_id',
        'empleado_id',
        'fecha_inicio',
        'fecha_fin',
        'dias',
        'tipo'
    ];

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }
}
