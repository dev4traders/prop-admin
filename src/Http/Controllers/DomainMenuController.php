<?php

namespace Dcat\Admin\Http\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Tree;
use Dcat\Admin\Admin;
use Illuminate\View\View;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\Enums\IconType;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Permission;
use Dcat\Admin\Http\Actions\Menu\DomainMenuToogleVisibilityRowAction;

class DomainMenuController extends AdminController
{
    public function title()
    {
        return trans('admin.menu');
    }

    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->helpTopic($this->helpTopic())
            ->description(__('admin.customize_menu'))
            ->withInfo('Press F5 to refresh sidebar menu') //todo:move to lang
            ->body(function (Row $row) {  $row->column(4, $this->treeView()->render());});
    }

    /**
     * @return \Dcat\Admin\Tree
     */
    protected function treeView()
    {
        $menuModel = config('admin.database.menu_model');

        return new Tree(new $menuModel(), function (Tree $tree) {

            $menu = request('menu');

            if(empty($menu)) {
                $menu = 'manager';
            }

            $tree->wrap(function(View $view) use($menu) {

                $tabs = new Tab();
                $tabs->withCard();

                if ($menu == 'manager')
                    $tabs->add('Manager Dashboard', $view, $menu == 'manager', 'manager');
                else
                    $tabs->addLink('Manager Dashboard', url()->current() . '?menu=manager');

                if ($menu == 'user')
                    $tabs->add('User Dashboard', $view, $menu == 'user', 'user');
                else
                    $tabs->addLink('User Dashboard', url()->current() . '?menu=user');

                return $tabs;
            });

            if($menu == 'manager') {
                $tree->query(function($query) {
                    return $query->whereHas('permissions', function($permission) {
                        return $permission->whereIn('id', Admin::user()->allPermissions()->pluck('id'));
                    })->orderBy('order');
                });
            } else {
                $tree->query(function($query) {
                    return $query->whereHas('permissions', function($permission) {
                        $permissionIds = Permission::whereHas('roles', function($role) {
                            return $role->whereIn('id',Admin::domain()->default_roles->pluck('id'));
                        })->pluck('id');
                        return $permission->whereIn('id', $permissionIds);
                    })->orderBy('order');
                });
            }

            $tree->disableCreateButton();
            $tree->disableQuickCreateButton();
            $tree->disableEditButton();
            $tree->disableDeleteButton();
            $tree->disableSaveButton();
            $tree->maxDepth(3);

            $tree->actions(function (Tree\Actions $actions) {
                $actions->prepend(new DomainMenuToogleVisibilityRowAction());
            });

            $tree->branch(function ($branch) {

                // if(is_null($branch['domain_setting']))
                //     return null;

                $icon = $branch['icon'];
                if(!is_null($branch['domain_setting']) && !is_null($branch['domain_setting']['icon'])) {
                    $icon = $branch['domain_setting']['icon'];
                }
                $payload = "<i class='fa {$icon}'></i>&nbsp;<strong>{$branch['title']}</strong>";

                return $payload;
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $menuModel = config('admin.database.menu_model');

        return new Form($menuModel::with('domain_setting'), function (Form $form) use ($menuModel) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });

            $form->display('title', 'Title');

            $form->hidden('domain_setting.domain_id')->value(Admin::domain()->id);
            $form->radio('domain_setting.icon_type', __('admin.icon_type'))->options(IconType::map())
                ->when(IconType::SVG->value, function(Form $form) {
                    $link = admin_url('svg-icons');
                    $form->svgIcon('domain_setting.icon_svg')->help("Manage SVG Icon at <a href='$link'>SVG Icons</a>");
                })
                ->when(IconType::FONT->value, function(Form $form) {
                    $form->icon('domain_setting.icon_font');
                })->default(IconType::FONT->value);

            $form->switch('domain_setting.visible', trans('admin.show'))->default(true);

            $form->saved(function (Form $form, $result) {
                $response = $form->response()->location('auth/domain-menu');

                if ($result) {
                    return $response->success(__('admin.save_succeeded'));
                }

                return $response->info(__('admin.nothing_updated'));
            });
        });
    }

}
