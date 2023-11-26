<?php

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Support\Helper;
use Illuminate\Support\Arr;

class Checkbox extends Radio
{
    protected $view = 'admin::widgets.checkbox';
    protected $checked;

    public function check(string|array $options) : Checkbox
    {
        $this->checked = Helper::array($options);

        return $this;
    }

    public function checkAll($excepts = []) : Checkbox
    {
        return $this->check(
            array_keys(Arr::except($this->options, $excepts))
        );
    }
}
