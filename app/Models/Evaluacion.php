<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    //
    use HasFactory;
    // Indicar la tabla correcta
    protected $table = 'evaluaciones';
    protected $fillable = [
        'entrevista_id',
        'evaluador_id',
        'puntaje_comunicacion',
        'puntaje_conocimiento',
        'puntaje_actitud',
        'puntaje_trabajo_equipo',
        'puntaje_total',
        'resultado_final',
        'comentarios',
    ];
    public function entrevista()
    {
        return $this->belongsTo(Entrevista::class);
    }
    // Relación con el usuario que evalúa
    public function evaluador()
    {
        return $this->belongsTo(User::class, 'evaluador_id');
    }
}
