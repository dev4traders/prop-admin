<?php

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Enums\StyleClassType;
use Illuminate\Contracts\Support\Renderable;

class Progress implements Renderable
{
    protected $view = 'admin::widgets.progress';

    protected string $class = '';
    protected string $height = '';

    public function __construct(
        StyleClassType $class = StyleClassType::PRIMARY,
        private int $value,
        private int $min = 0,
        private int $max = 100,
        private ?string $text = null,
        ?string $height = null,
        private bool $stripped = false,
        private bool $animated = false
    ){
        $this->class($class);
        $this->height($height);
    }

    public function height(?string $value = null) : Progress
    {
        if(!is_null($value))
            $this->height = 'height: '.$value;

        return $this;
    }

    public function class(StyleClassType $class) : Progress
    {
        $this->class = $class->value;

        return $this;
    }

    public function text(string $value) : Progress
    {
        $this->text = $value;

        return $this;
    }

    public function value(int $value) : Progress
    {
        $this->value = $value;

        return $this;
    }

    public function min(int $value) : Progress
    {
        $this->min = $value;

        return $this;
    }

    public function max(int $value) : Progress
    {
        $this->max = $value;

        return $this;
    }

    public function stripped(bool $value = true) : Progress
    {
        $this->stripped = $value;

        return $this;
    }

    public function animated(bool $value = true) : Progress
    {
        $this->animated = $value;
        return $this;
    }


    private function formatText() : string {
        return $this->text ?? $this->value.'%';
    }

    public function render()
    {
        $vars = [
            'stripped' => $this->stripped,
            'animated' => $this->animated,
            'value'    => $this->value,
            'min'      => $this->min,
            'max'      => $this->max,
            'height'   => $this->height,
            'text'     => $this->formatText(),
            'class'    => $this->class
        ];

        return view($this->view, $vars)->render();
    }

}
