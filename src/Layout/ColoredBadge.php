<?php

namespace Dcat\Admin\Layout;

use Dcat\Admin\Enums\StyleClassType;

class ColoredBadge
{
    public function __construct(public float|int|string $value, public StyleClassType $class = StyleClassType::INFO)
    {
    }
}
