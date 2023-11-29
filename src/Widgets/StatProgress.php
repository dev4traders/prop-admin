<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Enums\StyleClassType;
use Illuminate\Contracts\Support\Renderable;

class StatProgress implements Renderable
{
    protected $view = 'admin::widgets.stat-progress';
    protected ?string $description = null;
    protected bool $withCard = false;

    public function __construct(
        protected string $icon,
        protected string $title,
        protected int|float $value,
        protected string $valueTitle,
        protected StyleClassType $class = StyleClassType::PRIMARY,
    ) {}

    public function withCard() : StatProgress
    {
        $this->withCard = true;

        return $this;
    }

    public function class(StyleClassType $class) : StatProgress
    {
        $this->class = $class;

        return $this;
    }

    public function title(string $title) : StatProgress
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set contents.
     *
     */
    public function description(string $description) : StatProgress
    {
        $this->description = $description;

        return $this;
    }

    /**
     */
    public function value(int|float $value) : StatProgress
    {
        $this->value = $value;

        return $this;
    }

    public function valueTitle(string $title) : StatProgress
    {
        $this->valueTitle = $title;

        return $this;
    }

    /**
     * Add icon.
     *
     */
    public function icon(string $icon) : StatProgress
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     */
    public function render() : string
    {

        $progress = new Progress($this->class, $this->value);

        return view($this->view,[
            'title'        => $this->title,
            'description'      => $this->description,
            'icon'         => $this->icon,
            'value_title'        => $this->valueTitle,
            'progress' => $progress->render(),
            'class' => $this->class->value,
            'with_card'        => $this->withCard
        ])->render();
    }
}
