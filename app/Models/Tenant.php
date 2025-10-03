<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    // Aquí puedes agregar tus campos personalizados si quieres
    protected $fillable = [
        'id',
        'data',
    ];
}
