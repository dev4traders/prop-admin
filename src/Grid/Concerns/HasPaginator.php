<?php

namespace Dcat\Admin\Grid\Concerns;

use Dcat\Admin\Grid\Tools;
use Dcat\Admin\Grid\Tools\PerPageSelector;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait HasPaginator
{
    // /**
    //  * @var Tools\Paginator
    //  */
    // protected $paginator;
    public ?LengthAwarePaginator $paginator = null;
//    public ?PerPageSelector $perPageSelector = null;

    /**
     * Per-page options.
     *
     * @var array
     */
    protected $perPages = [10, 20, 30, 50, 100, 200];

    /**
     * Default items count per-page.
     *
     * @var int
     */
    protected $perPage = 20;

    /**
     * Paginate the grid.
     *
     * @param  int  $perPage
     * @return void
     */
    public function paginate(int $perPage = 20)
    {
        $this->perPage = $perPage;

        $this->model()->setPerPage($perPage);
    }

    /**
     * 是否使用 simplePaginate 方法分页.
     *
     * @param  bool  $value
     * @return $this
     */
    public function simplePaginate(bool $value = true)
    {
        $this->model()->simple($value);

        return $this;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param  string  $paginator
     * @return $this
     */
    public function setPaginatorClass(string $paginator)
    {
        $this->options['paginator_class'] = $paginator;

        return $this;
    }

    /**
     * Get the grid paginator.
     *
     * @return \Dcat\Admin\Grid\Tools\Paginator
     */
    public function paginator()
    {
        $this->paginator = $this->model()->paginator();

        if ($this->paginator instanceof LengthAwarePaginator) {
            $this->paginator->appends(request()->all());
        }

        // if (! $this->paginator) {
        //     $paginatorClass = $this->options['paginator_class'] ?: (config('admin.grid.paginator_class') ?: Tools\Paginator::class);

        //     $this->paginator = new $paginatorClass($this);
        // }

        return $this->paginator;
    }

    /**
     * If this grid use pagination.
     *
     * @return bool
     */
    public function allowPagination()
    {
        return $this->options['pagination'];
    }

    /**
     * Set per-page options.
     *
     * @param  array  $perPages
     */
    public function perPages(array $perPages)
    {
        $this->perPages = $perPages;

        return $this;
    }

    /**
     * @return $this
     */
    public function disablePerPages()
    {
        return $this->perPages([]);
    }

    /**
     * Get per-page options.
     *
     * @return array
     */
    public function getPerPages()
    {
        return $this->perPages;
    }

    /**
     * Disable grid pagination.
     *
     * @return $this
     */
    public function disablePagination(bool $disable = true)
    {
        $this->model->usePaginate(! $disable);

        return $this->option('pagination', ! $disable);
    }

    /**
     * Show grid pagination.
     *
     * @param  bool  $val
     * @return $this
     */
    public function showPagination(bool $val = true)
    {
        return $this->disablePagination(! $val);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|string
     */
    public function renderPagination()
    {
        $this->paginator();

        if(is_null($this->paginator))
            return '';

        return $this->paginator->render('admin::grid.pagination', ['selector' => new PerPageSelector($this)]);
        //return view('admin::grid.table-pagination', ['grid' => $this ]);
    }

    // public function renderPerPageSelector() : string {
    //     return (new PerPageSelector($this))->render();
    // }
}
