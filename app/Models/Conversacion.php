<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    use HasFactory;

    protected $table = 'conversaciones';

    protected $fillable = [
        'tenant_id',
        'empleado_id',
        'asunto',
        'estado',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class)->orderBy('created_at');
    }

    public function user()
    {
        // Accede al usuario a través del empleado
        return $this->empleado->user();
    }
}