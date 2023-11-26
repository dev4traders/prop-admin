<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\DcatIcon;

class Mobile extends Text
{
    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'mask' => '99999999999',
    ];

    public function render()
    {
        $this->inputmask($this->options);

        $this->defaultAttribute('style', 'width: 160px;flex:none');

        $this->prepend(DcatIcon::MOBILE(true));

        return parent::render();
    }
}
