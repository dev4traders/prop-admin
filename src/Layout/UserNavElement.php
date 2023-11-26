<?php

namespace Dcat\Admin\Layout;

use Illuminate\Contracts\Support\Renderable;

class UserNavElement implements Renderable
{

    protected $view = 'admin::widgets.user-nav-element';

    public function __construct(protected UserNav $nav, public string $url, public string $icon, public string $title, public ?ColoredBadge $badge = null,  public bool $hasDivider = false)
    {
    }

    public function render() : string {
        return view($this->view, ['url' => $this->url, 'icon' => $this->icon, 'title' => $this->title, 'badge' => $this->badge, 'hasDivider' => $this->hasDivider])->render();
    }
}
