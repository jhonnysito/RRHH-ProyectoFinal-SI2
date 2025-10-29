<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantCustomization extends Model
{
    protected $fillable = [
        'tenant_id',
        'logo',
        'primary_color',
        'secondary_color',
        'font_family',
    ];
}