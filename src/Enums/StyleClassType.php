<?php
declare(strict_types=1);

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum StyleClassType : string implements DcatEnum
{
    use DcatEnumTrait;

    case DARK = 'dark';
    case WARNING = 'warning';
    case INFO = 'info';
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case DANGER = 'danger';
    case SUCCESS = 'success';
}
