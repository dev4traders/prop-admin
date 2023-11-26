<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum LayoutContentType : string implements DcatEnum
{
    use DcatEnumTrait;

    case XXL = 'container-xxl';
    case FLUID = 'container-fluid';
}
