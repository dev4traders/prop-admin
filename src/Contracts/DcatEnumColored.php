<?php

namespace Dcat\Admin\Contracts;

use Dcat\Admin\Contracts\DcatEnum;

interface DcatEnumColored extends DcatEnum
{
    public function color(): string;
}
