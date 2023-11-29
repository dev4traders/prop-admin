<?php

namespace Dcat\Admin\Widgets;

use Dcat\Admin\DcatIcon;
use Dcat\Admin\Widgets\Widget;

class IconWithToolTip extends Widget
{
    public function __construct(protected string $icon, string $text)
    {
        $this->tooltip($text);
    }

    public function render()
    {
        $this->setHtmlAttribute('class', $this->icon);
        $atr = $this->formatHtmlAttributes();

        return <<<HTML
        <i $atr></i>
HTML;
    }
}
