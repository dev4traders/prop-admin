<?php

namespace Dcat\Admin\Grid\Actions;

use Dcat\Admin\DcatIcon;
use Dcat\Admin\Grid\RowAction;

class Edit extends RowAction
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
        //return '<i class="fas fa-pencil"></i> '.__('admin.edit').' &nbsp;&nbsp;';
        return DcatIcon::PENCIL(true, __('admin.edit'));
    }

    /**
     * @return string
     */
    public function href()
    {
        return $this->parent->getEditUrl($this->getKey());
    }
}
