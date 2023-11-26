<?php

namespace Dcat\Admin;

use App\DomainMailer;
use Illuminate\Bus\Queueable;
//use App\NotificationSubscribersNotifier;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Dcat\Admin\Models\SystemNotificationSetting;
use Dcat\Admin\Contracts\SubscribableNotificationInterface;
use Dcat\Admin\Contracts\DomainNotificationWithContextInterface;

abstract class SystemNotification extends Notification implements ShouldQueue, SubscribableNotificationInterface, DomainNotificationWithContextInterface
{
    use Queueable;
    //use DispatchesToSubscribers; //todo:: move to child class

    public int $domainId;

    protected string $viaBase = ''; // todo::move to child NotificationSubscribersNotifier::class;

    public function getDomainId() : int {
        return $this->domainId;
    }

    public function getTitle() : string {
        return SystemNotificationSetting::getTitle(get_class($this));
    }

    public function __construct(int $domainId)
    {
        $this->domainId = $domainId;

        $this->onQueue('default');
    }

    protected abstract function getVia($notifiable) : array;

    public function via($notifiable)
    {
        $via = [$this->viaBase];

        $setting = SystemNotificationSetting::forDomain($this->domainId)->where('type', SystemNotificationSetting::getTypeFromClass(get_class($this)))->first();

        if(!is_null($setting)) {
            if($setting->send_email) {
                $via[] = DomainMailer::class;
            }

            if($setting->send_notification) {
                $via[] = 'database';
            }
        }

        return array_unique(array_merge($this->getVia($notifiable), $via));
    }

}
