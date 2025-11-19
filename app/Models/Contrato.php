<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class Contrato extends Model
{
    use AutoAudit;    
    protected $table = 'contratos';

    protected $fillable = [
        'empleado_id',
        'sueldo',
        'fecha_inicio',
        'fecha_fin',
        'tipo',
        'observaciones',
        'tenant_id',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }


}
