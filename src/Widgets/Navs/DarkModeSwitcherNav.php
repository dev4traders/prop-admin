<?php

namespace Dcat\Admin\Widgets\Navs;

use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\NavElement;
use Illuminate\Contracts\Support\Renderable;

class DarkModeSwitcherNav implements Renderable, NavElement
{
    protected string $view = 'admin::widgets.darkmode-switcher-nav';

    public function __construct()
    {
    }

    public function render()
    {
        return view($this->view, ['current_mode' => Admin::darkMode()->value]);
    }
}
