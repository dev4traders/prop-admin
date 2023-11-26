<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum PlacementType : string implements DcatEnum
{
    use DcatEnumTrait;

    case TOP = 'top';
    case BOTTOM = 'bottom';
    case LEFT = 'left';
    case RIGHT = 'right';
}
