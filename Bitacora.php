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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bitacora',
        'id_usuario',
        'fecha',
        'ip',
        'so',
        'navegador',
        'usuario',
    ];

    /**
     * Get the user that owns the bitacora log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Get the details for the bitacora log.
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleBitacora::class);
    }
}
