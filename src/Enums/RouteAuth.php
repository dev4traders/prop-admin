<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum RouteAuth : string implements DcatEnum
{
    use DcatEnumTrait;

    case HOME = '/';
    case LOGIN = 'auth.login';
    case LOGOUT = 'auth.logout';
    case IMPERSONATE = 'auth.impersonate';
    case DEIMPERSONATE = 'auth.deimpersonate';
    case FORGOT_PASSWORD = 'auth.forgot_password';
    case REGISTER = 'auth.register';
    case SETTINGS = 'auth.settings';
    case DASH_SETTINGS = 'dash.settings';
}
