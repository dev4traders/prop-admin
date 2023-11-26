<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum ElementPositionType: string implements DcatEnum
{
    use DcatEnumTrait;

    case START = 'start';
    case END = 'end';
}
