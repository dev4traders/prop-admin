<?php

namespace Dcat\Admin\Form\Field;

class Time extends Date
{
    protected $format = 'HH:mm:ss';

    public function render()
    {
        $this->prepend('<i class="bx bx-watch"></i>')
            ->defaultAttribute('style', 'width: 200px;flex:none');

        return parent::render();
    }
}
