<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum LayoutType : string implements DcatEnum
{
    use DcatEnumTrait;

    case VERTICAL = 'vertical';
    case HORIZONTAL = 'horizontal';
}
