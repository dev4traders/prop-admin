<?php

namespace Dcat\Admin\Mails;

use Dcat\Admin\DomainTemplateMailable;
use Dcat\Admin\Contracts\DomainNotificationWithContextInterface;

class UserActivationRequiredMail extends DomainTemplateMailable
{
    public string $link = '/activate/123123';

    public function __construct( string $link, DomainNotificationWithContextInterface $notification)
    {
        $this->link = $link;

        parent::__construct($notification);
    }
}
