<?php

namespace Dcat\Admin\Http\Controllers;

use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Forms\DashboardSettingsForm;

class DashboardSettingsController extends Controller
{

    //protected $translation = 'dashboard-settings';

     public function index(Content $content): Content
     {
        return $content
            //->translation($this->translation())
            //->title($this->title())
            //->description($this->description())
            ->body(new Card(new DashboardSettingsForm()));
        //  return $content->header(__('site-config.site_config'))
        //      ->description('')
        //      ->body(new SiteConfigForm());
     }
}
