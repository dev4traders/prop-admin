<?php

namespace Dcat\Admin\Widgets\Navs;

use Illuminate\Contracts\Support\Renderable;

class LinkNav implements Renderable
{
    public function __construct(protected string $title, protected string $href, protected bool $isDisabled = false)
    {
    }

    public function render()
    {
        $disabled = $this->isDisabled ? 'disabled' : '';
        return <<<HTML
        <li class="nav-item">
          <a class="nav-link $disabled" href="{$this->href}" tabindex="-1">{$this->title}</a>
        </li>
HTML;
    }
}
