<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $table = 'incidencias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function permisos()
    {
        return $this->hasMany(PermisoEmpleado::class, 'incidencia_id');
    }
}
