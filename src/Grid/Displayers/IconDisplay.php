<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Admin;

class IconDisplay extends AbstractDisplayer
{

    public function display(string $icon = '', string $title = '', string $color = 'primary')
    {
        //dd($icon);
        return Admin::view(
            'admin::grid.displayer.icon',
            compact('icon', 'color', 'title')
        );
    }
}
