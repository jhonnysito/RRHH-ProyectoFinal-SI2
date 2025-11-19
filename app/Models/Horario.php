<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class Horario extends Model
{
    use HasFactory;
    use AutoAudit;
    protected $table = 'horarios';

    protected $fillable = [
        'tenant_id',
        'empleado_id',
        'dia_semana',
        'hora_entrada',
        'hora_salida',
    ];

    // Relaciones
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    // Asigna tenant automáticamente al crear
    protected static function booted()
    {
        static::creating(function ($horario) {
            if (auth()->check()) {
                $horario->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
}
