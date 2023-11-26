<?php

namespace Dcat\Admin\Grid\Displayers;

class PercentDisplay extends AbstractDisplayer
{

    public function display()
    {
        if(is_null($this->value))
            return '';

        return $this->value.'%';
    }
}
