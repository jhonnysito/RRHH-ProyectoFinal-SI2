<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait AutoAudit
{
    public static function bootAutoAudit()
    {
        static::created(function ($model) {
            $model->recordAudit('created', get_class($model), $model->id, null, $model->toArray());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            $original = $model->getOriginal();
            $model->recordAudit('updated', get_class($model), $model->id, $original, $changes);
        });

        static::deleted(function ($model) {
            $model->recordAudit('deleted', get_class($model), $model->id, $model->toArray(), null);
        });
    }

    public function recordAudit($accion, $modelo, $registro_id, $antes = null, $despues = null)
    {
        AuditLog::create([
            'tenant_id' => Auth::user()->tenant_id ?? null,
            'user_id'   => Auth::id(),
            'accion'    => $accion,
            'modelo'    => $modelo,
            'registro_id' => $registro_id,
            'datos_anteriores' => $antes,
            'datos_nuevos' => $despues,
            'ip'        => Request::ip(),
        ]);
    }
}
