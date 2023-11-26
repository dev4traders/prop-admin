<?php

namespace Dcat\Admin\Widgets\Metrics;

use Arr;
use Dcat\Admin\Admin;
use Illuminate\Support\Collection;

abstract class DonutWithLabels extends Donut
{

    protected abstract function getData() : Collection;

    protected function init()
    {
        parent::init();

        $counts = array();
        $labels = array();

        foreach($this->getData() as $label => $count) {
            $counts[] = $count;
            $labels[] = $label;
        }

        $this->chartLabels($labels);
        $this->chart([
            'series' => $counts
        ]);

        $this->contentWidth(0, 12);

    }

}
