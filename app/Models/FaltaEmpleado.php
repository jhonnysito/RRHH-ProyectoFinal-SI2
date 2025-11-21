<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaltaEmpleado extends Model
{
    protected $table = 'faltas_empleado';

    protected $fillable = [
        'tenant_id',
        'empleado_id',
        'pago_id',
        'fecha',
        'horas_afectadas',
        'motivo',
        'tipo',
        'descuento_generado'
    ];

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    public function pago()
    {
        return $this->belongsTo(PagoEmpleado::class, 'pago_id');
    }
}
