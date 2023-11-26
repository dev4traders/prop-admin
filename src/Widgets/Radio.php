<?php

namespace Dcat\Admin\Widgets;

//use Dcat\Admin\Enums\StyleClassType;
use Illuminate\Contracts\Support\Arrayable;

class Radio extends Widget
{
    protected $view = 'admin::widgets.radio';
    protected $checked;
    protected array $disabledValues = [];
    protected bool $inline = false;

    public function __construct(
        ?string $name = null,
        array $options = [],
//        StyleClassType $style = StyleClassType::PRIMARY
        string $style = 'primary'
    ) {
        $this->name($name);
        $this->options($options);
        $this->style($style);
    }

    public function name(?string $name) : Radio
    {
        return $this->setHtmlAttribute('name', $name);
    }

    public function inline(bool $inine = true) : Radio
    {
        $this->inline = $inine;

        return $this;
    }

    public function disable($values = null) : Radio
    {
        if ($values) {
            $this->disabledValues = (array) $values;

            return $this;
        }

        return $this->setHtmlAttribute('disabled', 'disabled');
    }

    public function check(string $option) : Radio
    {
        $this->checked = $option;

        return $this;
    }

    /**
     *
     * eg: $opts = [
     *         1 => 'foo',
     *         2 => 'bar',
     *         ...
     *     ]
     *
     * @param  array  $opts
     * @return $this
     */
    public function options($opts = []) : Radio
    {
        if ($opts instanceof Arrayable) {
            $opts = $opts->toArray();
        }
        $this->options = $opts;

        return $this;
    }

    // public function style(StyleClassType $style) : Radio
    // {
    //     $this->style = $style;

    //     return $this;
    // }

    public function defaultVariables() : array
    {
        return [
            'style'      => $this->style,
            'options'    => $this->options,
            'attributes' => $this->formatHtmlAttributes(),
            'checked'    => $this->checked,
            'disabled'   => $this->disabledValues,
            'inline'     => $this->inline
        ];
    }

}
