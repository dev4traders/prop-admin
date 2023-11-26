<?php

namespace Dcat\Admin\Grid\Tools;

use Illuminate\Contracts\Support\Renderable;

class RefreshButton implements Renderable
{
    protected $display = true;

    public function display($value)
    {
        $this->display = $value;

        return $this;
    }

    /**
     * Render refresh button of grid.
     *
     * @return string
     */
    public function render()
    {
        if (! $this->display) {
            return;
        }

        $refresh = trans('admin.refresh');

        return <<<EOT
<button data-action="refresh" class="btn btn-outline-success grid-refresh btn-mini" style="margin-right:3px">
    <i class="fas fa-refresh"></i><span class="d-none d-sm-inline">&nbsp; $refresh</span>
</button>
EOT;
    }
}
