<?php

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\DcatEnumColored;
use Dcat\Admin\Traits\DcatEnumTrait;

enum EmailDirectionType: int implements DcatEnumColored
{
    use DcatEnumTrait;

    case IN = 1;
    case OUT = 2;
    case REPLY = 3;

    public function color(): string
    {
        return match ($this) {
            self::IN    => '#49d758',
            self::OUT   => '#db633e',
            self::REPLY => '#db633e',
            default     => '#db633e'
        };
    }    
}
