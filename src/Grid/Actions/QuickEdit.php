<?php

namespace Dcat\Admin\Grid\Actions;

use Dcat\Admin\Form;
use Dcat\Admin\DcatIcon;
use Dcat\Admin\Grid\RowAction;

class QuickEdit extends RowAction
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
        //return '<i class="fas fa-pencil"></i> '.__('admin.quick_edit').' &nbsp;&nbsp;';
        return DcatIcon::PENCIL(true, __('admin.quick_edit'));
    }

    public function render()
    {
        [$width, $height] = $this->parent->option('dialog_form_area');

        $title = trans('admin.edit');

        Form::dialog($title)
            ->click(".{$this->getElementClass()}")
            ->dimensions($width, $height)
            ->forceRefresh()
            ->success('Dcat.reload()');

        $this->setHtmlAttribute([
            'data-url' => $this->parent->getEditUrl($this->getKey()),
        ]);

        return parent::render();
    }

    public function makeSelector()
    {
        return 'quick-edit';
    }
}
