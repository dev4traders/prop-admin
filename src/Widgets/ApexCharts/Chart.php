<?php

namespace Dcat\Admin\Widgets\ApexCharts;

use Dcat\Admin\Support\Helper;

class Chart extends ApexChartBase
{

    /**
     * @param  string|array  $title
     * @return $this
     */
    public function title($title)
    {
        if (is_string($title)) {
            $options = ['text' => $title];
        } else {
            $options = Helper::array($title);
        }

        $this->options['title'] = $options;

        return $this;
    }

    /**
     * @param  array  $value
     * @return $this
     */
    public function xaxis($value)
    {
        $this->options['xaxis'] = Helper::array($value);

        return $this;
    }

    /**
     * @param  array  $value
     * @return $this
     */
    public function yaxis($value)
    {
        $this->options['yaxis'] = Helper::array($value);

        return $this;
    }

    /**
     * @param  array  $value
     * @return $this
     */
    public function tip($value)
    {
        $this->options['tooltip'] = Helper::array($value);

        return $this;
    }
}
