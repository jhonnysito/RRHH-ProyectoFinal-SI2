<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     * Si no se especifica, Laravel asume el plural del nombre del modelo ("empleados").
     * Aquí la definimos explícitamente.
     */
    protected $table = 'empleados';

    /**
     * Campos que pueden asignarse masivamente.
     */
    protected $fillable = [
        'tenant_id',
        'nombre',
        'apellido',
        'ci',
        'cargo_id',
        'departamento_id',
        'direccion',
        'telefono',
        'correo',
        'estado',
    ];

    
     //Campos que deben tratarse como fechas.
     
    protected $dates = ['created_at', 'updated_at'];

    
  //  Relación: un empleado pertenece a un tenant (empresa)
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }


     //Relación: un empleado pertenece a un departamento.
     
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    
     // Relación: un empleado tiene un cargo.
     
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    /**
     * Accesor personalizado: devuelve el nombre completo del empleado.
     * Ejemplo de uso: $empleado->nombre_completo
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Scope: permite filtrar empleados activos fácilmente.
     * Ejemplo: Empleado::activos()->get();
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }

    /**
     * Scope: búsqueda general (por nombre, apellido o CI).
     */
    public function scopeBuscar($query, $termino)
    {
        if (!empty($termino)) {
            $query->where(function ($q) use ($termino) {
                $q->where('nombre', 'LIKE', "%{$termino}%")
                  ->orWhere('apellido', 'LIKE', "%{$termino}%")
                  ->orWhere('ci', 'LIKE', "%{$termino}%");
            });
        }
        return $query;
    }
}
