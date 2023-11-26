<?php

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class DarkModeSwitcher implements Renderable
{
    protected string $view = 'admin::widgets.darkmode-switcher';

    public function __construct()
    {
    }

    public function render()
    {
        return view($this->view, ['current_mode' => Admin::darkMode()->value]);
    }
}
