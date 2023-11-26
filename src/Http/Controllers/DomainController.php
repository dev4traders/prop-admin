<?php

namespace Dcat\Admin\Http\Controllers;

use Dcat\Admin\Admin;
use Dcat\Admin\Enums\HttpSchemaType;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Models\Administrator;

class DomainController extends AdminController
{

    protected $title = 'Domains';

    protected function grid()
    {
        $model = config('admin.database.domains_model');

        return new Grid( $model::with('manager'), function (Grid $grid) {

            $grid->column('schema')->select(HttpSchemaType::map());
            $grid->column('host')->editable();
            $grid->column('manager.username', trans('admin.manager'));

            if (config('admin.permission.enable')) {
                $grid->column('default_roles')->pluck('name')->label('primary', 3);
            }

            $grid->disableFilterButton();
            $grid->disableRefreshButton();
            $grid->disableViewButton();
        });
    }

    protected function form()
    {
        $model = config('admin.database.domains_model');
        return new Form( $model::with(['manager','default_roles']), function (Form $form) {

            $form->text('host')->required();
            $form->select('schema')->options(HttpSchemaType::map())->default(HttpSchemaType::HTTPS)->required();

            $users = Administrator::whereManagerId(Admin::user()->id)->pluck('username', 'id');
            $form->select('manager_id', trans('admin.manager'))->options($users)->required();

            if (config('admin.permission.enable')) {
                $form->multipleSelect('default_roles', trans('admin.roles'))
                    ->options(function () {
                        /** @var Model $roleModel */
                        $roleModel = config('admin.database.roles_model');

                        return $roleModel::all()->pluck('name', 'id');
                    })
                    ->customFormat(function ($v) {
                        return array_column($v, 'id');
                    });
            }

            $form->disableViewButton();
        });
    }
}