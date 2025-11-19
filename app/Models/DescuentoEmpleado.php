<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DescuentoEmpleado extends Model
{
    protected $table = 'descuentos_empleado';

    protected $fillable = [
        'tenant_id',
        'empleado_id',
        'pago_id',
        'tipo',
        'monto',
        'corresponde_a_mes'
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
