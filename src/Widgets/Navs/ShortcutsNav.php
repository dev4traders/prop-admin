<?php

namespace Dcat\Admin\Widgets\Navs;

use Dcat\Admin\DcatIcon;
use Dcat\Admin\Contracts\NavElement;
use Dcat\Admin\Traits\HasBuilderEvents;

class ShortcutsNav implements NavElement
{
    protected string $view = 'admin::widgets.shortcuts';

    use HasBuilderEvents;

    protected array $elements = [];
    protected bool $canAddShortcut = false;

    public function __construct( \Closure $builder )
    {
        $builder($this);
    }

    protected function canAddShortcut(bool $value = false) {
        $this->canAddShortcut = $value;
    }

    public function add(DcatIcon $icon, string $title, string $description, string $url) : ShortcutsNav
    {
        $this->elements[] = [
            'icon' => $icon->_(),
            'title' => $title,
            'description' => $description,
            'url' => $url,
        ];

        return $this;
    }

    public function view(string $view) : ShortcutsNav
    {
        $this->view = $view;

        return $this;
    }

    public function render()
    {
        return view($this->view, ['items' => $this->elements, 'canAddShortcut' => $this->canAddShortcut])->render();
    }
}
