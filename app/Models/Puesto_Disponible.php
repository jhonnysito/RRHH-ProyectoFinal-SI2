<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class Puesto_Disponible extends Model
{
    use HasFactory;
    use AutoAudit;
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
        'postulado', // <-- agregar aquí
    ];

    // Relación con Tenant (si usas Tenancy)
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function postulantes()
    {
        return $this->hasMany(Postulante::class, 'puesto_disponible_id');
    }
}
