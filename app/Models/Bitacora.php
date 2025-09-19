<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bitacora extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bitacoras';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ID_Usuario',
        'entrada',
        'salida',
        'usuario',
        'tipo',
        'direccionIp',
        'navegador',
    ];

    /**
     * Get the user that owns the bitacora log.
     */


    /**
     * Get the details for the bitacora log.
     */
    public function detallebitacoras()
    {
        return $this->hasMany(DetalleBitacora::class, 'ID_Bitacora');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ID_Usuario');
    }
}
