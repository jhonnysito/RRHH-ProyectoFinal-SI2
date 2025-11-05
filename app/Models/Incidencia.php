<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Incidencia. Representa los diferentes tipos de permisos
 * que puede solicitar un empleado (vacaciones, enfermedad, asuntos personales, etc.).
 *
 * NOTA: Asumo que esta tabla ya existe o se creará. La columna 'incidencia_id' en la tabla
 * 'permisos' hace referencia a esta tabla.
 */
class Incidencia extends Model
{
    use HasFactory;

    protected $table = 'incidencias'; // Ajusta el nombre si tu tabla se llama diferente.

    protected $fillable = [
        'nombre', // Ej: 'Vacaciones', 'Enfermedad', 'Asuntos Personales'
        'descripcion',
        'requiere_aprobacion', // booleano, si se requiere un supervisor
    ];

    // Relación: Un permiso pertenece a un tipo de incidencia.
    public function permisos()
    {
        return $this->hasMany(Permiso::class, 'incidencia_id');
    }
}