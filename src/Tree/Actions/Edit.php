<?php

namespace Dcat\Admin\Tree\Actions;

use Dcat\Admin\Tree\RowAction;

class Edit extends RowAction
{
    public function html()
    {
        return <<<HTML
<a href="{$this->resource()}/{$this->getKey()}/edit"><i class="fas fa-pencil"></i>&nbsp;</a>
HTML;
    }
}
