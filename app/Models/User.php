<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasRoles, BelongsToTenant;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'stripe_id',       // <-- ¡AÑADE ESTO!
        'pm_type',         // <-- ¡AÑADE ESTO!
        'pm_last_four',    // <-- ¡AÑADE ESTO!
        'trial_ends_at',   // <-- ¡AÑADE ESTO!
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class, 'ID_Usuario');
    }
    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'user_id');
    }

    // Relación con Postulante
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function evaluacionesRealizadas()
    {
        return $this->hasMany(Evaluacion::class, 'evaluador_id');
    }

    
    public function conversaciones()
    {
        return $this->belongsToMany(Conversacion::class, 'conversacion_participantes');
    }
    public function pagos()
{
    return $this->hasMany(PagoEmpleado::class, 'empleado_id');
}
}
