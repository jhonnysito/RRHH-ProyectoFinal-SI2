<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'tenant_id',
        'empleado_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'estado',
        'observacion',
    ];

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    // Relación con tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    // Asigna el tenant automáticamente al crear un registro
    protected static function booted()
    {
        static::creating(function ($asistencia) {
            if (auth()->check()) {
                $asistencia->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
}
