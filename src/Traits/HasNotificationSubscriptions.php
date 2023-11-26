<?php

namespace Dcat\Admin\Traits;

use Dcat\Admin\Models\NotificationSubscription;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasNotificationSubscriptions
{
    public function notificationSubscriptions(): HasMany
    {
        return $this->hasMany(NotificationSubscription::class, 'user_id');
    }

    public function isSubscribedToNotification($type): bool
    {
        return $this->notificationSubscriptions()
            ->forType($type)
            ->exists();
    }
}
