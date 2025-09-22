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
        'informacion', 
        'disponible', 
    ];
}
