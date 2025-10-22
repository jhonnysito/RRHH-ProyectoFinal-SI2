<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    protected $fillable = ['tenant_id', 'nombre', 'descripcion'];


     // Un departamento tiene muchos cargos
    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }

    // Un departamento pertenece a un tenant (empresa)
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    // Un departamento puede tener muchos empleados
     public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}
