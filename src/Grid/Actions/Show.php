<?php

namespace Dcat\Admin\Grid\Actions;

use Dcat\Admin\DcatIcon;
use Dcat\Admin\Grid\RowAction;

class Show extends RowAction
{
    /**
     * @return array|null|string
     */
    public function title()
    {
        if ($this->title) {
            return $this->title;
        }

        //todo::rm
        //return '<i class="fas fa-eye"></i> '.__('admin.show').' &nbsp;&nbsp;';
        return DcatIcon::EYE(true, __('admin.show'));
    }

    /**
     * @return string
     */
    public function href()
    {
        return $this->parent->urlWithConstraints("{$this->resource()}/{$this->getKey()}");
    }
}
