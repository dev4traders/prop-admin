<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum LayoutDirectionType : string implements DcatEnum
{
    use DcatEnumTrait;

    case LTR = 'ltr';
    case RTL = 'rtl';
}
