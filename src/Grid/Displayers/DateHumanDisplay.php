<?php

namespace Dcat\Admin\Grid\Displayers;

use Carbon\Carbon;

class DateHumanDisplay extends AbstractDisplayer
{

    public function display()
    {

        if(is_null($this->value))
            return '';

        return $this->value->diffForHumans();
    }
}
