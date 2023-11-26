<?php

namespace Dcat\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class ImageAdv implements Renderable
{
    public function __construct(protected string $src, protected string $srcDark, protected string $alt, protected string $height = '140')
    {
    }

    public function render()
    {
        return <<<HTML
<img src="{$this->src}" height="{$this->height}" alt="{$this->alt}" data-app-dark-img="{$this->srcDark}" data-app-light-img="{$this->src}">
HTML;
    }
}
