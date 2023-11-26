<?php

namespace Dcat\Admin\Widgets\Metrics;

use Dcat\Admin\Admin;

class Donut extends Card
{
    /**
     * 图表高度.
     *
     * @var int
     */
    protected $chartHeight = 100;

    /**
     * 图表上间距.
     *
     * @var int
     */
    protected $chartMarginTop = 5;

    /**
     * 内容宽度.
     *
     * @var array
     */
    protected $contentWidth = [6, 6];

    /**
     * 趋势图图表默认配置.
     *
     * @return array
     */
    protected function defaultChartOptions()
    {
        $color = Admin::color();

        $colors = [
            $color->primary(),
            $color->success(),
            $color->info(),
            $color->warning(),
            $color->danger()
        ];

        return [
            'chart' => [
                'type' => 'donut',
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'colors' => $colors,
            'legend' => [
                'show' => true,
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
            'stroke' => [
                'width' => 0,
            ],
        ];
    }

    /**
     * 初始化.
     */
    protected function init()
    {
        parent::init();

        // 使用图表
        $this->useChart();

        // 默认样式
        //$this->chart->style('margin: 10px 5px 0 0;width: 150px;float:right;');
    }

    /**
     * 设置内容宽度.
     *
     * @param  int  $left
     * @param  int  $right
     * @return $this
     */
    public function contentWidth(int $left, int $right)
    {
        $this->contentWidth = [$left, $right];

        return $this;
    }

    /**
     * 渲染内容，加上图表.
     *
     * @return string
     */
    public function renderContent()
    {
        $content = parent::renderContent();

        return <<<HTML
<div class="d-flex row justify-content-between">
    <div class="col-sm-{$this->contentWidth[0]} justify-content-center">
        {$content}
    </div>
    <div class="col-sm-{$this->contentWidth[1]}" style="margin-right: -15px;">
        {$this->renderChart()}
    </div>
</div>
HTML;
    }
}
