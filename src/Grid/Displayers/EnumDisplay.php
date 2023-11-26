<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\DcatEnum;

class EnumDisplay extends AbstractDisplayer
{

    public function display()
    {

        if(is_null($this->value))
            return '';

        if(class_implements($this->value, DcatEnum::class) ) {
            /** @var DcatEnum $this->value */
            return $this->value->label();
        }
    }
}
