<?php

namespace Dcat\Admin\Grid\Tools;

use Dcat\Admin\Grid;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Dropdown;
use Illuminate\Support\Collection;
use Dcat\Admin\Widgets\DropdownItem;
use Dcat\Admin\Enums\ButtonClassType;
use Dcat\Admin\Enums\ButtonSizeType;
use Illuminate\Contracts\Support\Renderable;

class PerPageSelector implements Renderable
{
    /**
     * @var Grid
     */
    protected $parent;

    /**
     * @var string
     */
    protected $perPage;

    /**
     * @var string
     */
    protected $perPageName = '';

    /**
     * Create a new PerPageSelector instance.
     *
     * @param  Grid  $grid
     */
    public function __construct(Grid $grid)
    {
        $this->parent = $grid;

        $this->initialize();
    }

    /**
     * Do initialize work.
     *
     * @return void
     */
    protected function initialize()
    {
        $this->perPageName = $this->parent->model()->getPerPageName();

        $this->perPage = (int) app('request')->input(
            $this->perPageName,
            $this->parent->getPerPage()
        );
    }

    /**
     * Get options for selector.
     *
     * @return static
     */
    public function getOptions() : Collection
    {
        return collect($this->parent->getPerPages())
            ->push($this->parent->getPerPage())
            ->push($this->perPage)
            ->unique()
            ->sort();
    }

    /**
     * Render PerPageSelector。
     *
     * @return string
     */
    public function render()
    {
        Admin::script($this->script());

        $options = $this->getOptions()->map(function ($option) {
            $url = app('request')->fullUrlWithQuery([$this->perPageName => $option]);

            return new DropdownItem($option, $url);
        })->toArray();

        return (new Dropdown($options))
            ->up()
            ->button($this->perPage)
            ->buttonClass(ButtonClassType::PRIMARY, true)
            ->size(ButtonSizeType::SM)
            ->render();
    }

    /**
     * Script of PerPageSelector.
     *
     * @return string
     */
    protected function script()
    {
        return <<<JS
$('.{$this->parent->getPerPageName()}').change(function() {
    Dcat.reload(this.value);
});
JS;
    }
}
