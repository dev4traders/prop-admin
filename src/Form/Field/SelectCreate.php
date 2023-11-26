<?php


namespace Dcat\Admin\Form\Field;

use Dcat\Admin\Form;
use Dcat\Admin\Form\Field\Select;
use Dcat\Admin\Support\Helper;

class SelectCreate extends Select
{
    protected $url = null;

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->addDefaultConfig([
            'allowClear' => true,
            'placeholder' => [
                'id' => '',
                'text' => $this->placeholder(),
            ],
        ]);

        $this->formatOptions();

        $this->addVariables([
            'options' => $this->options,
            'groups' => $this->groups,
            'configs' => $this->config,
            'cascadeScript' => $this->getCascadeScript(),
            'createDialog' => $this->build()
        ]);

        $this->attribute('data-value', implode(',', Helper::array($this->value())));

        return parent::render();
    }

    protected function build(): string
    {
        Form::dialog(__('admin.select_create'))
            ->click('.create-form')
            ->url($this->url)
            ->width('1200px')
            ->height('800px');

        $text = __('admin.select_create');

        return "<span class='btn btn-primary create-form' data-url='$this->url'> $text </span>";
    }

    public function url($url): SelectCreate
    {
        $this->url = $url;
        return $this;
    }
}
