<?php

namespace Dcat\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class Accordion extends Widget implements Renderable
{
    protected $view = 'admin::widgets.accordion';

    protected array $items = [];

    public function __construct()
    {
        $this->id('accordion-'.uniqid());
    }

    /**
     * Add item.
     *
     * @param string $title
     * @param string $content
     *
     * @return $this
     */
    public function add(string $title, string $content, string $icon = NULL, bool $collapsed = false)
    {
        $this->items[] = [
            'title'   => $title,
            'content' => $content,
            'icon' => $icon,
            'collapsed' => $collapsed,
        ];

        return $this;
    }

    public function defaultVariables()
    {
        return [
            'id'         => $this->id,
            'items'      => $this->items,
            'attributes' => $this->formatHtmlAttributes(),
        ];
    }
}
