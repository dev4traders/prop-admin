<?php

namespace Dcat\Admin\Widgets\Navs;

use Dcat\Admin\Contracts\NavElement;
use Dcat\Admin\Traits\HasBuilderEvents;
use Illuminate\Contracts\Support\Renderable;

class NotificationNav implements Renderable, NavElement
{
    protected string $view = 'admin::widgets.notifications';

    use HasBuilderEvents;

    protected array $elements = [];
    protected string $viewAllLink = '/notifications';

    public function __construct(string $viewAllLink )
    {

        $this->viewAllLink = $viewAllLink;
    }

    public function add(string $icon, string $title, string $message, string $time, bool $isRead = false) : NotificationNav
    {
        $this->elements[] = [
            'icon' => $icon,
            'title' => $title,
            'time' => $time,
            'message' => $message,
            'is_read' => $isRead,
        ];

        return $this;
    }

    public function view(string $view) : NotificationNav
    {
        $this->view = $view;

        return $this;
    }

    public function render()
    {
        return view($this->view, ['items' => $this->elements, 'view_all_link' => $this->viewAllLink])->render();
    }
}
