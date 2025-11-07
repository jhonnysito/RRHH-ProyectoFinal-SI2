<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    use HasFactory;

    /**
     * ¡Correcto!
     */
    protected $table = 'conversaciones';

    /**
     * ¡Correcto! (empleado_id ya no está)
     */
    protected $fillable = [
        'tenant_id',
        'asunto',
        'estado',
    ];

    public function participantes()
    {
        return $this->belongsToMany(User::class, 'conversacion_participantes');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class)->orderBy('created_at');
    }
}