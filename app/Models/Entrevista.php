<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class Entrevista extends Model
{
    use HasFactory;
    use AutoAudit;
    protected $fillable = ['postulante_id', 'fecha', 'hora', 'notas'];

    // Relación con Postulante
    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
