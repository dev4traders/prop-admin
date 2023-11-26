<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Contracts\ColoredTag;

class TagsColoredDisplay extends AbstractDisplayer
{

    public function display()
    {

        if(is_null($this->value))
            return '';
        
        return collect($this->value)->map(function ($tag) {
            if(class_implements($tag, ColoredTag::class) ) {
                return  "<span title='{$tag->getTag()}' class='label' style='background-color:{$tag->getColor()}'>&nbsp;&nbsp;</span>";
            }
        })->implode(' ');

    }
}
