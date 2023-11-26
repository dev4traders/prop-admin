<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\DcatIcon;

class Url extends Text
{
    protected $rules = ['nullable', 'url'];

    public function render()
    {
        $this->prepend(DcatIcon::INTERNET(true))
            ->defaultAttribute('type', 'url');

        return parent::render();
    }
}
