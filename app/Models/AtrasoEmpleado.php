<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtrasoEmpleado extends Model
{
    protected $table = 'atrasos_empleado';

    protected $fillable = [
        'tenant_id',
        'empleado_id',
        'pago_id',
        'fecha',
        'minutos_tarde',
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
