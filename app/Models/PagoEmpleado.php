<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoEmpleado extends Model
{
    protected $table = 'pagos_empleados';

    protected $fillable = [
        'tenant_id',
        'empleado_id',
        'salario_base',
        'total_bonos',
        'total_descuentos',
        'total_neto',
        'periodo_inicio',
        'periodo_fin',
        'fecha_pago',
        'estado',
    ];

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    public function faltas()
    {
        return $this->hasMany(FaltaEmpleado::class, 'pago_id');
    }

    public function atrasos()
    {
        return $this->hasMany(AtrasoEmpleado::class, 'pago_id');
    }

    public function bonos()
    {
        return $this->hasMany(BonoEmpleado::class, 'pago_id');
    }

    public function descuentos()
    {
        return $this->hasMany(DescuentoEmpleado::class, 'pago_id');
    }
}
