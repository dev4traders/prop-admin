<?php

namespace Dcat\Admin\Widgets;

class InfoBox extends Widget
{
    protected $view = 'admin::widgets.info-box';

    protected $title;
    protected $content;
    protected $color;
    protected $link;
    protected $icon;
    protected $padding;

    public function __construct($content, $color = 'info', $title = null, $icon = null, $link = null)
    {
        $title && $this->title($title);
        $content && $this->content($content);
        $icon && $this->icon($icon);
        $link && $this->link($link);

        $this->class("small-box bg-$color");
    }

    public function content($content)
    {

        $this->content = $this->formatRenderable($content);

        return $this;
    }

    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    public function link($link)
    {
        $this->link = $link;

        return $this;
    }

    public function color($color)
    {
        $this->class("small-box bg-$color");

        return $this;
    }

    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function padding(string $padding)
    {
        $this->padding = 'padding:'.$padding;

        return $this;
    }

    public function defaultVariables()
    {
        return [
            'title'      => $this->title,
            'icon'      => $this->icon,
            'link'      => $this->link,
            'content'    => $this->toString($this->content),
            'attributes' => $this->formatHtmlAttributes(),
            'padding'    => $this->padding,
        ];
    }
}
