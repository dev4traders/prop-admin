<?php

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Widgets\Widget;
use Dcat\Admin\Enums\ButtonClassType;

class Button extends Widget
{
    public function __construct(protected string $title, protected ButtonClassType $type = ButtonClassType::PRIMARY)
    {
    }

    public function render()
    {
        $this->class($this->type->_());

        $atr = $this->formatHtmlAttributes();

//        dd($atr);

        return <<<HTML
        <button type="button" $atr>$this->title</button>
HTML;
    }
}
