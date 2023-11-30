<?php

namespace Dcat\Admin\Widgets\ApexCharts;

use Illuminate\Support\Str;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Widgets\Widget;
use Dcat\Admin\Support\JavaScript;
use Dcat\Admin\Traits\InteractsWithApi;

/**
 * Class Chart.
 *
 *
 * @see https://apexcharts.com/
 */
class ApexChartBase extends Widget
{
    use InteractsWithApi;

    public static $js = [
        '@apex-charts',
    ];

    protected $containerSelector;

    protected $built = false;

    public function __construct($selector = null, array $options = [])
    {
        if ($selector && ! is_string($selector)) {
            $options = $selector;
            $selector = null;
        }

        $this->selector($selector);

        $this->options($options);
    }

    /**
     *
     * @param  string|null  $selector
     * @return $this|string|null
     */
    public function selector(?string $selector = null)
    {
        if ($selector === null) {
            return $this->containerSelector;
        }

        $this->containerSelector = $selector;

        if ($selector && ! $this->built) {
            $this->autoRender();
        }

        return $this;
    }

    /**
     * @param  array  $series
     * @return $this
     */
    public function series($series)
    {
        $this->options['series'] = Helper::array($series);

        return $this;
    }

    /**
     * @param  array  $value
     * @return $this
     */
    public function labels($value)
    {
        $this->options['labels'] = Helper::array($value);

        return $this;
    }

    /**
     * @param  string|array  $colors
     * @return $this
     */
    public function colors($colors)
    {
        $this->options['colors'] = Helper::array($colors);

        return $this;
    }

    /**
     * @param  array  $value
     * @return $this
     */
    public function stroke($value)
    {
        $this->options['stroke'] = Helper::array($value);

        return $this;
    }

    public function fill(array $value) : ApexChartBase
    {
        $this->options['fill'] = Helper::array($value);

        return $this;
    }

    /**
     * @param  array  $value
     * @return $this
     */
    public function chart(array $value)
    {
        $this->options['chart'] = Helper::array($value);

        return $this;
    }

    /**
     * @param  array|bool  $value
     * @return $this
     */
    public function dataLabels($value)
    {
        if (is_bool($value)) {
            $value = ['enabled' => $value];
        }

        $this->options['dataLabels'] = Helper::array($value);

        return $this;
    }

    protected function buildDefaultScript() : string
    {
        $options = JavaScript::format($this->options);

        return <<<JS
(function () {
    var options = {$options};

    var chart = new ApexCharts(
        $("{$this->containerSelector}")[0],
        options
    );
    chart.render();
})();
JS;
    }

    public function addScript() : string
    {
        if (! $this->allowBuildRequest()) {
            return $this->script = $this->buildDefaultScript();
        }

        $this->fetched(
            <<<JS
if (! response.status) {
    return Dcat.error(response.message || 'Server internal error.');
}

var chartBox = $(response.selector || '{$this->containerSelector}');

if (chartBox.length) {
    chartBox.html('');

    if (typeof response.options === 'string') {
        eval(response.options);
    }

    setTimeout(function () {
        new ApexCharts(chartBox[0], response.options).render();
    }, 50);
}
JS
        );

        return $this->script = $this->buildRequestScript();
    }

    public function render() : string
    {
        if ($this->built) {
            return '';
        }
        $this->built = true;

        return parent::render();
    }

    public function html()
    {
        $hasSelector = $this->containerSelector ? true : false;

        if (! $hasSelector) {
            $id = $this->generateId();

            $this->selector('#'.$id);
        }

        $this->addScript();

        if ($hasSelector) {
            return;
        }

        $this->setHtmlAttribute([
            'id' => $id,
        ]);

        return <<<HTML
<div {$this->formatHtmlAttributes()}></div>
HTML;
    }

    public function valueResult() : array
    {
        return [
            'status'   => 1,
            'selector' => $this->containerSelector,
            'options'  => $this->formatScriptOptions(),
        ];
    }

    protected function formatScriptOptions() : string
    {
        $code = JavaScript::format($this->options);

        return "response.options = {$code}";
    }

    protected function generateId() : string
    {
        return 'apex-chart-'.Str::random(8);
    }
}
