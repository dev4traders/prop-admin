<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\DcatEnum;
use Dcat\Admin\DcatEnumColored;

class EnumColoredDisplay extends AbstractDisplayer
{

    public function display()
    {

        if(is_null($this->value))
            return '';

        if(class_implements($this->value, DcatEnum::class) ) {
            /** @var DcatEnum $this->value */
            if(class_implements($this->value, DcatEnumColored::class) ) {
                return '<span class="label" style="background:'.$this->value->color().'">'.$this->value->label().'</span>';
            }

            return $this->value->label();
        }
    }
}
