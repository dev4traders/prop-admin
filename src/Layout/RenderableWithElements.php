<?php

namespace Dcat\Admin\Layout;

use Dcat\Admin\Support\Helper;
use Dcat\Admin\Traits\HasBuilderEvents;
use Dcat\Admin\Enums\ElementPositionType;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;

class RenderableWithElements implements Renderable
{
    use HasBuilderEvents;

    protected array $elements = [];

    public function __construct()
    {
        $this->elements[ElementPositionType::START->value] = collect();
        $this->elements[ElementPositionType::END->value] = collect();
    }

    public function start(string|\Closure|Renderable|Htmlable $element) : RenderableWithElements
    {
        $this->elements[ElementPositionType::START->value]->push($element);

        return $this;
    }

    public function end(string|\Closure|Renderable|Htmlable $element) : RenderableWithElements
    {
        $this->elements[ElementPositionType::END->value]->push($element);

        return $this;
    }

    public function render( ElementPositionType $position = ElementPositionType::END)
    {
        $this->callComposing($position);

        if ($this->elements[$position->value]->isEmpty()) {
            return '';
        }

        return $this->elements[$position->value]->map([Helper::class, 'render'])->implode('');
    }
}
