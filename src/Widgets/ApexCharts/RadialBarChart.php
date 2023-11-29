<?php

namespace Dcat\Admin\Widgets\ApexCharts;

use Dcat\Admin\Widgets\ApexCharts\ApexChartBase;

class RadialBarChart extends ApexChartBase
{

    protected int $holowSize = 70;
    protected int $offset = 0;
    protected int $height = 380;
    protected array $padding = [
        'top' => -75,
        'bottom' => -75,
        'left' => -20,
        'right' => -20
    ];

    public function __construct($selector = null, array $options = [])
    {
        parent::__construct($selector, $options);
    }

    public function hollowSize(int $size): RadialBarChart
    {
        $this->holowSize = $size;

        return $this;
    }

    public function height(int $value): RadialBarChart
    {
        $this->height = $value;

        return $this;
    }

    public function value(int $value): RadialBarChart
    {
        $this->series([$value]);

        return $this;
    }

    public function offset(int $value): RadialBarChart
    {
        $this->offset = $value;

        return $this;
    }

    public function padding(array $value): RadialBarChart
    {
        $this->padding = $value;

        return $this;
    }

    protected function setupOptions(): void
    {
        $this->chart([
            'type' => 'radialBar',
            'height' => $this->height,
            'sparkline' => [
                'enabled' => true
            ],
            //'parentHeightOffset' => 0
        ]);

        $this->options([
            'grid' => [
                'padding' => $this->padding
            ],
            'plotOptions' => [
                'radialBar' => [
                    'dataLabels' => [
                        'show' => false
                    ],
                    'hollow' => [
                        'size' => $this->holowSize . '%',
                    ]
                ],
            ],
        ]);
    }

    public function render(): string
    {
        $this->setupOptions();

        return parent::render();
    }
}
