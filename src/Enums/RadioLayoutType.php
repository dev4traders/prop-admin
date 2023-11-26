<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum RadioLayoutType: int implements DcatEnum {
    use DcatEnumTrait;

    case COMMON = 1;
    case BOXED = 2;
    case BUTTON = 3;

};
