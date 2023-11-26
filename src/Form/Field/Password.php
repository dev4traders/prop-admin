<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\DcatIcon;

class Password extends Text
{
    public function render()
    {
        $this->prepend(DcatIcon::HIDE(true))
            ->defaultAttribute('type', 'password');

        return parent::render();
    }
}
