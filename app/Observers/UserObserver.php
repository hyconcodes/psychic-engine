<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class UserObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if (isset($new['banned_until'])) {
            $oldBan = $old['banned_until'] ?? null;
            $newBan = $new['banned_until'];

            if (! $oldBan && $newBan) {
                return "User @{$model->username} banned until {$newBan}";
            } elseif ($oldBan && ! $newBan) {
                return "User @{$model->username} unbanned";
            } elseif ($newBan) {
                return "User @{$model->username} ban updated to {$newBan}";
            }
        }

        return "User @{$model->username} updated";
    }
}
