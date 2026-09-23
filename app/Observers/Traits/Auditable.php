<?php

namespace App\Observers\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            static::recordAudit($model, 'created');
        });

        static::updated(function ($model) {
            static::recordAudit($model, 'updated');
        });

        static::deleted(function ($model) {
            static::recordAudit($model, 'deleted');
        });
    }

    protected static function recordAudit($model, string $event): void
    {
        $oldValues = $event === 'created' ? [] : $model->getOriginal();
        $newValues = $model->getAttributes();

        if ($event === 'updated') {
            $changed = array_diff_assoc($newValues, $oldValues);
            if (empty($changed)) {
                return;
            }
            $newValues = $changed;
            $oldValues = array_intersect_key($oldValues, $changed);
        }

        AuditLog::create([
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'event' => $event,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => static::getDescription($model, $event, $oldValues, $newValues),
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    abstract protected static function getDescription($model, string $event, array $old, array $new): string;
}
