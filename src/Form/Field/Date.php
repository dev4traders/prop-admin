<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\DcatIcon;

class Date extends Text
{
    public static $js = [
        '@moment',
        '@bootstrap-datetimepicker',
    ];
    public static $css = [
        '@bootstrap-datetimepicker',
    ];

    protected $format = 'YYYY-MM-DD';

    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    protected function prepareInputValue($value)
    {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function render()
    {
        $this->options['format'] = $this->format;
        $this->options['locale'] = config('app.locale');
        $this->options['allowInputToggle'] = true;

        $options = admin_javascript_json($this->options);

        $this->script = <<<JS
Dcat.init('{$this->getElementClassSelector()}', function (self) {
    self.datetimepicker({$options});
});
JS;

        $this->prepend(DcatIcon::CALENDAR(true))
            ->defaultAttribute('style', 'width: 200px;flex:none');

        return parent::render();
    }
}
