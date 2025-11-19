<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class DetalleBitacora extends Model
{
    use HasFactory;
    use AutoAudit;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalle_bitacoras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ID_Bitacora',
        'accion',
        'metodo',
        'hora',
        'tabla',
        'registroId',
        'ruta',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the main bitacora log that this detail belongs to.
     */
    public function bitacora(): BelongsTo
    {
        return $this->belongsTo(Bitacora::class, 'ID_Bitacora');
    }
}
