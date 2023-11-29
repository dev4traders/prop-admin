<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class StatItem implements Renderable
{
    protected $view = 'admin::widgets.stat-item';
    protected bool $inverse = false;
    protected bool $withCard = false;

    public function __construct(
        protected string $icon,
        protected string $title,
        protected string $description,
        protected ?string $value = null)
    {
    }

    public function inverse() : StatItem
    {
        $this->inverse = true;

        return $this;
    }

    public function withCard() : StatItem
    {
        $this->withCard = true;

        return $this;
    }

    /**
     * Set title.
     *
     */
    public function title(string $title) : StatItem
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set contents.
     *
     */
    public function description(string $description) : StatItem
    {
        $this->description = $description;

        return $this;
    }

    /**
     */
    public function value(string $value) : StatItem
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Add icon.
     *
     */
    public function icon(string $icon) : StatItem
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     */
    public function render() : string
    {
        return view($this->view,[
            'title'        => $this->title,
            'description'      => $this->description,
            'icon'         => $this->icon,
            'value'        => $this->value,
            'inverse'        => $this->inverse,
            'with_card'        => $this->withCard
        ])->render();
    }
}
