<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

class DropdownItem
{
    public function __construct(public string $value, public ?string $link = null, public bool $hasDivider = false, public bool $isDisabled = false)
    {
    }
}
