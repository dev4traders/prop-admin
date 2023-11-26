<?php

namespace Dcat\Admin\Enums;

enum ButtonSizeType : string
{
    public const PREFIX = 'btn-';

    case XL = 'xl';
    case LG = 'lg';
    case DEF = '';
    case SM = 'sm';
    case XS = 'xs';

    public function _() {
        return self::format($this);
    }

    public static function __callStatic($name, $args)
    {
        $cases = static::cases();

        foreach ($cases as $case) {
            if ($case->name === $name) {
                return self::format($case);
            }
        }
    }

    public static function format(ButtonSizeType $icon)  : string {
        return self::PREFIX.$icon->value;
    }
}
