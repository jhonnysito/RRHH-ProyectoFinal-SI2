<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    

    protected $fillable = ['tenant_id','nombre', 'descripcion', 'departamento_id'];

    // Relación: un cargo pertenece a un departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
     // Un cargo pertenece a un tenant (empresa)
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    // Un cargo tiene muchos empleados
    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}