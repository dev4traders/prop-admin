<?php

namespace Dcat\Admin\Mails;

use Dcat\Admin\DomainTemplateMailable;
use Dcat\Admin\Contracts\DomainNotificationWithContextInterface;

class UserCreatedMail extends DomainTemplateMailable
{
    public string $user_name = 'login';
    public string $email = '1@1.com';
    public string $name = 'Marcus';
    public string $password = 'secret';
    public string $url_dashboard = 'http://test.com';

    public function __construct( string $userName, string $email, string $name, string $password, string $url_dashboard, DomainNotificationWithContextInterface $notification)
    {
        $this->user_name = $userName;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->url_dashboard = $url_dashboard;

        parent::__construct($notification);
    }

}
