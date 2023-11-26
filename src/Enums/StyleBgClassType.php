<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum StyleBgClassType : string implements DcatEnum
{
    use DcatEnumTrait;

    case DARK = 'bg-dark';
    case WARNING = 'bg-warning';
    case INFO = 'bg-info';
    case PRIMARY = 'bg-primary';
    case SECONDARY = 'bg-secondary';
    case DANGER = 'bg-danger';
    case SUCCESS = 'bg-success';
}
