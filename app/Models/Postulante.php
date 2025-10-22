<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    use HasFactory;

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'cv',
        'skills',
        'experiencia_anios',
        // --- CAMPOS DE IA AÑADIDOS ---
        'ai_skills',
        'ai_suggested_job',
        // -----------------------------
    ];

    // Definir la relación con las solicitudes de empleo (un postulante puede tener muchas solicitudes)
    public function solicitudes()
    {
        return $this->hasMany(SolicitudEmpleo::class);
    }
}
