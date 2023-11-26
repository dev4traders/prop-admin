<?php

namespace Dcat\Admin\Widgets\Cards;

use Dcat\Admin\DcatIcon;
use Dcat\Admin\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;

class ProfitCard extends Widget
{
    protected $view = 'admin::widgets.cards.card-profit';

    public function __construct(
        protected string $title,
        protected string $value,
        protected string $subtitle,
        protected DcatIcon $icon,
        protected Renderable $toolButton,
        protected string $link,
        protected bool $growing = true
    ) {
    }

    public function growing(bool $value = true) : ProfitCard {
        $this->growing = $value;

        return $this;
    }

    public function defaultVariables() : array
    {
        return [
            'attributes' => $this->formatHtmlAttributes(),
            'growing'      => $this->growing,
            'title'      => $this->title,
            'value'    => $this->value,
            'icon'    => $this->icon->_(),
            'subtitle'    => $this->subtitle,
            'toolButton'    => $this->toolButton,
            'link'   => $this->link
        ];
    }

}
