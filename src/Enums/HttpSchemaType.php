<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum HttpSchemaType: string implements DcatEnum
{
    use DcatEnumTrait;

    case HTTP = 'http';
    case HTTPS = 'https';
}
