<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class PlanObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if ($event === 'created') {
            return "Plan created: {$model->name} at ₦{$model->price}";
        }

        $changes = [];
        if (isset($new['price']) && $new['price'] != ($old['price'] ?? null)) {
            $changes[] = "price: ₦{$old['price']} → ₦{$new['price']}";
        }
        if (isset($new['is_active']) && $new['is_active'] != ($old['is_active'] ?? null)) {
            $changes[] = 'active: '.($old['is_active'] ? 'yes' : 'no').' → '.($new['is_active'] ? 'yes' : 'no');
        }

        return $changes ? "Plan {$model->name} updated: ".implode(', ', $changes) : "Plan {$model->name} updated";
    }
}
