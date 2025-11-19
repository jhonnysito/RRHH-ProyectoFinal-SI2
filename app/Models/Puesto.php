<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class Puesto extends Model
{
    use HasFactory;
    use AutoAudit;
    protected $fillable = [
        'nombre',
        'descripcion',
        'vacantes',
        'ubicacion',
    ];
}