<?php

// app/Models/LocationRecord.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoAudit; // <-- asegúrate de importar tu trait

class LocationRecord extends Model
{
    use HasFactory;
    use AutoAudit;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'recorded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'recorded_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
