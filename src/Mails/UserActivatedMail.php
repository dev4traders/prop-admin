<?php

namespace Dcat\Admin\Mails;

use Dcat\Admin\DomainTemplateMailable;
use Dcat\Admin\Contracts\DomainNotificationWithContextInterface;

class UserActivatedMail extends DomainTemplateMailable
{
    public string $login = 'dummy-login';
    public string $url = 'http://example.com';

    public function __construct( string $login, string $loginUrl, DomainNotificationWithContextInterface $notification)
    {
        $this->login = $login;
        $this->url = $loginUrl;

        parent::__construct($notification);
    }
}
