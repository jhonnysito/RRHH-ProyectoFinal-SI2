<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    

    protected $fillable = ['nombre', 'descripcion', 'departamento_id'];

    // Relación: un cargo pertenece a un departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}