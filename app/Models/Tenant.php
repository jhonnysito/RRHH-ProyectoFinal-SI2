<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Domain;

class Tenant extends BaseTenant
{
    use HasDomains;
    use Billable;
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

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
