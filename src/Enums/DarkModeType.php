<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum DarkModeType : string implements DcatEnum
{
    use DcatEnumTrait;

    case LIGHT = 'sun';
    case DARK = 'moon';
    case SYSTEM = 'desktop';
}
