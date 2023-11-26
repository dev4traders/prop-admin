<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum IconType : int implements DcatEnum
{
    use DcatEnumTrait;

    case SVG = 0;
    case FONT = 1;
}
