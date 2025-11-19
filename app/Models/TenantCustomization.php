<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class TenantCustomization extends Model
{
    use AutoAudit;
    protected $fillable = [
        'tenant_id',
        'logo',
        'primary_color',
        'secondary_color',
        'font_family',
    ];
}