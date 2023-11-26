<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\DcatIcon;

class Ip extends Text
{
    protected $rules = ['nullable', 'ip'];

    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'alias' => 'ip',
    ];

    public function render()
    {
        $this->inputmask($this->options);

        $this->defaultAttribute('style', 'width: 160px;flex:none');

        $this->prepend(DcatIcon::LAPTOP(true))
            ->defaultAttribute('style', 'width: 200px');

        return parent::render();
    }
}
