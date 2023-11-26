<?php

namespace Dcat\Admin\Grid\Displayers;

class PriceDisplay extends AbstractDisplayer
{

    public function display(string $curency = '$')
    {
        if(is_null($this->value))
            return '';

        if(is_string($this->value)) {
            $this->value = (float)$this->value;
        }

        if($this->value < 0) {
            return '-'.$curency.abs($this->value);
        }

        return $curency.$this->value;
    }
}
