<?php

namespace Dcat\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Dcat\Admin\DomainTemplateMailable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Dcat\Admin\Mails\NotificationSubscriptionMail;
use Dcat\Admin\Contracts\EmailContextObjectInterface;
use Dcat\Admin\Contracts\SubscribableNotificationInterface;
use Dcat\Admin\Contracts\DomainNotificationWithContextInterface;

class NotificationSubscriptionNotification extends Notification implements ShouldQueue, DomainNotificationWithContextInterface
{
    use Queueable;

    public string $title;
    public string $message;
    public int $domainId;

    public function __construct(SubscribableNotificationInterface $notification, string $message, int $domainId)
    {
        $this->title = $notification->getTitle();

        $this->message = $message;
        $this->domainId = $domainId;

        $this->onQueue('default');
    }

    public function getDomainId(): int
    {
        return $this->domainId;
    }

    public function getContextObject(): ?EmailContextObjectInterface
    {
        return null;
    }

    public function via($notifiable)
    {
        return [DomainMailer::class, 'database'];
    }

    public function toDomainMailer($notifiable) : DomainTemplateMailable
    {
        return (
            new NotificationSubscriptionMail(
                $this->title,
                $this->message,
                $this
            )
        );
    }

    public function toArray($notifiable) {
        return ['message' => $this->title.' : '.$this->message];
    }

}
