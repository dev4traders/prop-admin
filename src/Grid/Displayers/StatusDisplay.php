<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Admin;

class StatusDisplay extends AbstractDisplayer
{

    public function color($color)
    {
        $this->color = Admin::color()->get($color);
    }

    public function display(string $color = '')
    {
        $column = $this->column->getName();
        if ($color instanceof \Closure) {
            $color->call($this->row, $this);
        } else {
            $this->color($color);
        }

        $color = $this->color ?: Admin::color()->primary();
        $checked = $this->value ? 'checked' : '';

        return Admin::view(
            'admin::grid.displayer.status',
            compact('column', 'checked', 'color')
        );
    }
}
