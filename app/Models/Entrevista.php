<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrevista extends Model
{
    use HasFactory;

    protected $fillable = ['postulante_id', 'fecha', 'hora', 'notas'];

    // Relación con Postulante
    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }
    
}
