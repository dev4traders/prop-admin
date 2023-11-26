<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

use Dcat\Admin\DcatIcon;
use Illuminate\Support\Str;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Enums\ButtonClassType;
use Dcat\Admin\Enums\ButtonSizeType;
use Illuminate\Contracts\Support\Arrayable;

class Dropdown extends Widget
{
    protected $view = 'admin::widgets.dropdown';

    /** @var DropdownItem[] $items */
    protected array $items = [];

    protected array $button = [];

    protected string $buttonId = '';

    protected bool $click = FALSE;

    protected string $direction = 'down';

    protected bool $isRounded = false;

    /** @var DropdownItem[] $items */
    public function __construct($items = [])
    {
        $this->button = [
            'text' => NULL,
            'class' => ButtonClassType::SECONDARY(),
            'size_class' => ButtonSizeType::DEF,
            'icon' => NULL,
            'arrow' => FALSE,
            'split' => FALSE,
        ];

        $this->items($items);

        return $this;
    }

    /** @var DropdownItem[] $items */
    public function items( array $items = []): Dropdown
    {
        // //$this->items = array_merge($this->items, Helper::array($options));
        // if ($options instanceof Arrayable) {
        //     $options = $options->toArray();
        // }

        $this->items = array_merge($this->items, $items);

        return $this;
    }

    public function rounded(bool $value = true) : Dropdown {
        $this->isRounded = $value;

        return $this;
    }

    /**
     * Set the button text.
     */
    public function button(?string $text = null): Dropdown
    {
        $this->button['text'] = $text;
        return $this;
    }

    public function icon(DcatIcon $icon): Dropdown
    {
        $this->button['icon'] = $icon->_();
        return $this;
    }

    /**
     * Set the button class.
     */
    public function buttonClass(ButtonClassType $class, bool $isOutline = false): Dropdown
    {
        $this->button['class'] = $class->_($isOutline);
        return $this;
    }

    public function size(ButtonSizeType $class ): Dropdown
    {
        $this->button['size_class'] = $class->_();

        return $this;
    }

    public function hideArrow(): Dropdown
    {
        $this->button['arrow'] = TRUE;
        return $this;
    }

    public function toggleSplit(): Dropdown
    {
        $this->button['split'] = TRUE;
        return $this;
    }

    public function direction(string $direction = 'down'): Dropdown
    {
        $this->direction = $direction;
        return $this;
    }

    public function up(): Dropdown
    {
        return $this->direction('up');
    }

    public function down(): Dropdown
    {
        return $this->direction('down');
    }

    public function start(): Dropdown
    {
        return $this->direction('start');
    }

    public function end(): Dropdown
    {
        return $this->direction('end');
    }

    /**
     * Add click event listener.
     */
    public function click(?string $defaultLabel = NULL): Dropdown
    {
        $this->click = TRUE;
        $this->buttonId = 'dropd-' . Str::random(8);
        if ($defaultLabel !== NULL) {
            $this->button($defaultLabel);
        }
        return $this;
    }

    public function getButtonId(): string
    {
        return $this->buttonId;
    }

    public function add(string $title, ?string $url = null, bool $disabled = FALSE, bool $hasDivider = FALSE): Dropdown
    {
        $this->items[] =  new DropdownItem($title, $url, $hasDivider, $disabled);

        return $this;
    }

    public function render(): string
    {
        $this->addVariables([
            'items' => $this->items,
            'button' => $this->button,
            'buttonId' => $this->buttonId,
            'click' => $this->click,
            'direction' => $this->direction,
            'rounded' => $this->isRounded
        ]);
        return parent::render();
    }
}
