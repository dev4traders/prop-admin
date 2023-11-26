<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\Form\Field;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Enums\RadioLayoutType;
use Illuminate\Contracts\Support\Arrayable;
use Dcat\Admin\Widgets\Radio as WidgetRadio;

class Radio extends Field
{
    use CanCascadeFields;
    use CanLoadFields;
    use Sizeable;

    protected $style = 'primary';

    protected $cascadeEvent = 'change';

    protected $inline = true;

    protected RadioLayoutType $layout = RadioLayoutType::COMMON;
    protected string $boxed_width = "150px";
    protected string $boxed_height = "100px";

    /**
     * @param  array|\Closure|string|Arrayable  $options
     * @return $this
     */
    public function options($options = [])
    {
        if ($options instanceof \Closure) {
            $this->options = $options;

            return $this;
        }

        if ($options instanceof Arrayable) {
            $this->options = $options->toArray();

            return $this;
        }

        $this->options = Helper::array($options);

        return $this;
    }

    public function inline(bool $inline)
    {
        $this->inline = $inline;

        return $this;
    }

    public function layout(RadioLayoutType $layout, string $width = "150px", string $height = "100px")
    {
        $this->layout = $layout;
        $this->boxed_width = $width;
        $this->boxed_height = $height;

        return $this;
    }

    /**
     * "info", "primary", "inverse", "danger", "success", "purple".
     *
     * @param  string  $style
     * @return $this
     */
    public function style(string $style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ($this->options instanceof \Closure) {
            $this->options(
                $this->options->call($this->values(), $this->value(), $this)
            );
        }

        $this->addCascadeScript();

        $radio = WidgetRadio::make($this->getElementName(), $this->options, $this->style);

        if ($this->attributes['disabled'] ?? false) {
            $radio->disable();
        }

        $radio
            ->inline($this->inline)
            ->check($this->value())
            ->class($this->getElementClassString())
            ->size($this->size)
            ->layout($this->layout, $this->boxed_width, $this->boxed_height);
            
        if(!empty($this->innerView))
            $radio->view($this->innerView);

        $this->addVariables([
            'radio' => $radio,
        ]);

        return parent::render();
    }
}