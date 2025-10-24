<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Puesto_Disponible;

class Postulante extends Model
{
    use HasFactory;

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'tenant_id',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'cv',
        'skills',
        'experiencia_anios',
        // --- CAMPOS DE IA AÑADIDOS ---
        'ai_skills',
        'puntuacion',
        'puesto_disponible_id'
        // -----------------------------
    ];

    // Definir la relación con las solicitudes de empleo (un postulante puede tener muchas solicitudes)
    public function solicitudes()
    {
        return $this->hasMany(SolicitudEmpleo::class);
    }
     public function puesto()
    {
        return $this->belongsTo(Puesto_Disponible::class, 'puesto_disponible_id');
    }
}
