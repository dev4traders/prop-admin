<?php

namespace Dcat\Admin\Widgets\Navs;

use Illuminate\Support\Str;
use Dcat\Admin\Widgets\Tooltip;
use Dcat\Admin\Enums\StyleClassType;
use Dcat\Admin\Enums\ButtonClassType;
use Illuminate\Contracts\Support\Renderable;

class ButtonNav implements Renderable
{
    private string $tipClass = '';

    public function __construct(protected string $title, protected string $href, protected ButtonClassType $btn = ButtonClassType::PRIMARY, protected StyleClassType $class = StyleClassType::PRIMARY, protected ?string $tip = null)
    {

        if ($this->tip) {
            $this->tipClass = 'tt-'.Str::random(4);;
            Tooltip::make('.'.$this->tipClass)
                ->bottom()
                ->title($this->tip);
        }

    }

    public function render()
    {

        $btnClass = $this->btn->_();
        $class = $btnClass.'-'.$this->class->value;

        return <<<HTML
<a href="{$this->href}" class="{$this->tipClass}"><button class="$class" type="button">{$this->title}</button></a>
HTML;
    }
}
