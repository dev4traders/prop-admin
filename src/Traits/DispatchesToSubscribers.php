<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Dcat\Admin\Models\NotificationSubscription;

trait DispatchesToSubscribers
{

    public static function dispatchToSubscribers()
    {
        Notification::route( NotificationSubscribersNotifier::class, '')->notify(new static(...func_get_args()));
    }

    public static function getSubscribers(int $domainId) : Collection
    {
        return NotificationSubscription::query()
            ->forType(self::class)
            ->forDomain($domainId)
            ->get()
            ->map(fn (NotificationSubscription $notificationSubscription) => (
                $notificationSubscription->user
            ))
            ->filter()
            ->unique();
    }

    public function subscribers() : Collection
    {
        return self::getSubscribers($this->getDomainId());
    }
}
