<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\DcatIcon;

class Email extends Text
{
    protected $rules = ['nullable', 'email'];

    public function render()
    {
        $this->prepend(DcatIcon::EMAIL(true))
            ->type('email');

        return parent::render();
    }
}
