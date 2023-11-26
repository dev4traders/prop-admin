<?php

namespace Dcat\Admin\Traits;

use Illuminate\Support\Collection;
use Dcat\Admin\Repositories\DashboardNotification;
use Illuminate\Notifications\DatabaseNotification;

trait HasDashboardNotifications
{

    public function dashboardNotifications(int $top = 10): Collection
    {
        $notifications = DatabaseNotification
            ::take($top)
            ->unread()
            ->where('notifiable_id', $this->id)
            ->get();

        return $notifications->map(function(DatabaseNotification $notification) {
            return DashboardNotification::fromDatabaseNotification($notification);
        });
    }

}
