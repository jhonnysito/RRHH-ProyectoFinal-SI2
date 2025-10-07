<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    protected $fillable = ['tenant_id', 'nombre', 'descripcion'];

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }

    //opcional
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
