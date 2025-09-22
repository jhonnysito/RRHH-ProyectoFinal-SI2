<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    protected $fillable = ['nombre', 'descripcion'];

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }   

}


