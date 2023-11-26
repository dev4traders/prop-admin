<?php

declare(strict_types=1);

namespace Dcat\Admin\Enums;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\Traits\DcatEnumTrait;

enum ButtonClassType : string implements DcatEnum
{
    use DcatEnumTrait;

    public const PREFIX = 'btn-';
    public const BASE = 'btn ';

    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case SUCCESS = 'success';
    case DANGER = 'danger';
    case WARNING = 'warning';
    case INFO = 'info';

    //case NONE = '';

    public function _(bool $isOutline = false) {
        return self::format($this, $isOutline);
    }

    public static function __callStatic($name, $args)
    {
        $outline = false;
        if($args && count($args) > 0) {
            $outline = true;
        }
        $cases = static::cases();

        foreach ($cases as $case) {
            if ($case->name === $name) {
                return self::format($case, $outline);
            }
        }
    }

    public static function format(ButtonClassType $icon, bool $isOutline = false)  : string {
        return self::BASE.self::PREFIX.($isOutline ? 'outline-' : '').$icon->value;
    }
}
