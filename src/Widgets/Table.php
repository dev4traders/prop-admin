<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

use Illuminate\Support\Arr;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Enums\StyleClassType;
use Illuminate\Contracts\Support\Renderable;

class Table implements Renderable
{
    protected string $view = 'admin::widgets.table';

    protected string $class = '';
    protected ?string $headerClass = null;
    protected bool $withBorder = false;
    protected bool $withFooter = false;
    protected bool $withHover = false;
    protected bool $striped = false;
    protected bool $small = false;
//todo:Lfix or remove
//    protected int $depth = 0;

    public function __construct(protected array $headers = [], protected array $rows = [], ?StyleClassType $class = null)
    {
        $this->class($class);
    }

    /**
     * Set table headers.
     */
    public function setHeaders(array $headers = []) : Table
    {
        $this->headers = $headers;

        return $this;
    }

    //todo:Lfix or remove
    /**
     */
    // public function depth(int $depth) : Table
    // {
    //     $this->depth = $depth;

    //     return $this;
    // }

    public function class(?StyleClassType $class) : Table
    {
        if($class)
            $this->class = $class->value;

        return $this;
    }

    public function headerClass(?StyleClassType $class) : Table
    {
        if($class)
            $this->headerClass = $class->value;

        return $this;
    }

    /**
     * Set table rows.
     *
     * @param  array  $rows
     * @return $this
     */
    public function setRows(array $rows = [])
    {
        if ($rows && ! Arr::isAssoc(Helper::array($rows, false))) {
            $this->rows = $rows;

            return $this;
        }

        //todo::fix or remove
        // $noTrPadding = false;

        // foreach ($rows as $key => $item) {
        //     if (is_array($item)) {
        //         if (Arr::isAssoc($item)) {
        //             $borderLeft = $this->depth ? 'table-left-border-nofirst' : 'table-left-border';

        //             $item = static::make($item)
        //                 ->depth($this->depth + 1)
        //                 ->class('table-no-top-border '.$borderLeft, true)
        //                 ->render();

        //             if (! $noTrPadding) {
        //                 $this->class('table-no-tr-padding', true);
        //             }
        //             $noTrPadding = true;
        //         } else {
        //             $item = json_encode($item, JSON_UNESCAPED_UNICODE);
        //         }
        //     }

        //     $this->rows[] = [$key, $item];
        // }

        return $this;
    }

    public function render() : string
    {
        $vars = [
            'headers'    => $this->headers,
            'rows'       => $this->rows,
            'class'       => $this->class,
            'headerClass'       => $this->headerClass,
            'withFooter'       => $this->withFooter,
            'withBorder'       => $this->withBorder,
            'withHover'       => $this->withHover,
            'striped'       => $this->striped,
            'small'       => $this->small,
        ];

        return view($this->view, $vars)->render();
    }

    public function withBorder() : Table
    {
        $this->withBorder = true;

        return $this;
    }

    public function withFooter() : Table
    {
        $this->withFooter = true;

        return $this;
    }

    public function withHover() : Table
    {
        $this->withHover = true;

        return $this;
    }

    public function striped() : Table
    {
        $this->striped = true;

        return $this;
    }

    public function small() : Table
    {
        $this->small = true;

        return $this;
    }
}
