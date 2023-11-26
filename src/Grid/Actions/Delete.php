<?php

namespace Dcat\Admin\Grid\Actions;

use Dcat\Admin\DcatIcon;
use Dcat\Admin\Grid\RowAction;

class Delete extends RowAction
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
        //return '<i class="fas fa-trash"></i> '.__('admin.delete').' &nbsp;&nbsp;';
        return DcatIcon::TRASH(true, __('admin.delete'));
    }

    public function render()
    {
        $this->setHtmlAttribute([
            'data-url'      => $this->url(),
            'data-message'  => "ID - {$this->getKey()}",
            'data-action'   => 'delete',
            'data-redirect' => $this->redirectUrl(),
        ]);

        return parent::render();
    }

    protected function redirectUrl()
    {
        return $this->parent->model()->withoutTreeQuery(request()->fullUrl());
    }

    public function url()
    {
        return "{$this->resource()}/{$this->getKey()}";
    }
}
