<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Domain;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class Tenant extends BaseTenant
{
    use HasDomains;
    use Billable;
    use AutoAudit;
    // Aquí puedes agregar tus campos personalizados si quieres
    protected $fillable = [
        'id',
        'data',
    ];


    public function url(string $path = '/'): string
    {
        $domain = $this->domains()->first()?->domain ?? "{$this->id}.mi-saas.com";

        return "http://{$this->domains()->first()->domain}{$path}";
    }
    //relaciones parav- Si quieres navegar desde el tenant hacia sus departamentos con sintaxis elegante ($tenant->departamentos).

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }

    public function puestos_disponibles()
    {
        return $this->hasMany(Puesto_Disponible::class);
    }
    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    public function customization()
    {
        return $this->hasOne(TenantCustomization::class);
    }
}
