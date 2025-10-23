<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto_Disponible extends Model
{
    use HasFactory;
    protected $table = 'puestos_disponibles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'area',
        'descripcion',
        'requisitos',
        'tipo_contrato',
        'modalidad',
        'nivel',
        'salario',
        'ubicacion',
        'vacantes',
        'fecha_limite',
        'estado',
        'beneficios',
        'tenant_id',
    ];

    // Relación con Tenant (si usas Tenancy)
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
