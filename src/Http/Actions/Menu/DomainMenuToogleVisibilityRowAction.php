<?php

namespace Dcat\Admin\Http\Actions\Menu;

use Dcat\Admin\Admin;
use Dcat\Admin\Tree\RowAction;
use Dcat\Admin\Models\MenuDomainSetting;

class DomainMenuToogleVisibilityRowAction extends RowAction
{
    public function handle()
    {
        $key = $this->getKey();

        $menu = MenuDomainSetting::where('menu_id',$key)->first();

        if(is_null($menu)) {
            $menu = new MenuDomainSetting();
            $menu->menu_id = $key;
            $menu->domain_id = Admin::domain()->id;
            $menu->visible = false;

            $menu->save();
        } else {
            $menu->update(['visible' => $menu->visible ? 0 : 1]);
        }

        return $this
            ->response()
            ->success(trans('admin.update_succeeded'))
            ->location('auth/domain-menu');
    }

    public function title()
    {
        
        $visible = $this->getRow()->show;

        if(!is_null($this->getRow()->domain_setting)) {
            $visible = $this->getRow()->domain_setting->visible;
        }

        $icon = $visible ? 'icon-eye-off' : 'icon-eye';

        return "&nbsp;<i class='feather $icon'></i>&nbsp;";
    }
}
