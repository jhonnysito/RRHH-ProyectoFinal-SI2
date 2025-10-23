<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudEmpleo extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'tenant_id',
        'postulante_id', // Relación con el postulante
        'puesto',        // Puesto solicitado
        'mensaje',       // Mensaje de la solicitud
        'estado',        // Estado de la solicitud (pendiente, aceptado, rechazado)
    ];

    /**
     * Relación con el modelo Postulante.
     * Esto permite acceder al postulante desde una solicitud de empleo.
     */
    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
