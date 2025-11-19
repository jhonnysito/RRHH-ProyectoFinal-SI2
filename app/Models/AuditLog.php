<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    // Si está en otra DB:
    protected $connection = 'audit_pgsql';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'accion',
        'modelo',
        'registro_id',
        'datos_anteriores',
        'datos_nuevos',
        'ip',
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
    ];
}
