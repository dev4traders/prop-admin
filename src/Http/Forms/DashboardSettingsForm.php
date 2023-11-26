<?php

namespace Dcat\Admin\Http\Forms;

use Illuminate\Support\Str;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\CodemirrorMode;
use Dcat\Admin\Form\Field\SwitchField;

class DashboardSettingsForm extends Form
{
    public function handle(array $input)
    {
        $data = array();
        foreach($input as $key=>$val) {
            $t =  Str::of($key)->replace('_', '.');
            $data[(string)$t] = $val;
        }

        admin_setting($data);

        return $this
            ->response()
            ->location(admin_url('dashboard-settings'))
            ->success(___('updated_success'));
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        $this->tab(__('dashboard-settings.basic'), function(Form $form) {
            $form->text('admin_powered', __('dashboard-settings.powered_by'))
                ->default(config('admin.powered'));

            $form->text('admin_name', __('dashboard-settings.name'))
                ->default(config('admin.name'));

            $form->text('admin_title', __('dashboard-settings.title'))
                ->default(config('admin.title'));

            // $this->switch('admin_layout_horizontal-menu', __('dashboard-settings.top_menu'))->default(config('admin.layout.horizontal-menu'));

            // $this->switch('admin_contactus-enabled', __('dashboard-settings.contactus_enabled'))
            //     ->default(config('admin.contactus-enabled'));

            // $this->switch('admin_layout_dark-mode-switch', __('dashboard-settings.dark_mode_switch'))
            //     ->default(config('admin.layout.dark-mode-switch'));

            // $form->text('admin_contactus-link', __('dashboard-settings.contactus_link'))->default(config('admin.contactus-link'));

            // $form->text('admin_wordpress_host', __('dashboard-settings.wordpress_host'))->default(config('admin.wordpress.host'));
            // $form->text('admin_wordpress_client-id', __('dashboard-settings.wordpress_client_id'))->default(config('admin.wordpress.client-id'));
            // $form->text('admin_wordpress_client-secret', __('dashboard-settings.wordpress_client_secret'))->default(config('admin.wordpress.client-secret'));;;

            // $this->radio('admin_layout_sidebar-style', __('dashboard-settings.menu_style'))
            //     ->options(['light' => 'Light', 'dark' => 'Dark'])
            //     ->default(config('admin.layout.sidebar-style'));

            // $this->radio('admin_login-layout', __('dashboard-settings.login_layout'))
            //     ->options(['primary' => 'Primary', 'left' => 'Left Aligned'])
            //     ->default(config('admin.login-layout'));

            // $this->radio('admin_layout_color', __('dashboard-settings.base_color'))
            //     ->options(['default' => 'Default', 'blue' => 'Blue', 'blue-light' => 'Light Blue', 'blue-dark' => 'Dark Blue', 'green' => 'Green', 'black' => 'Black', 'yellow' => 'Yellow', 'brown' => 'Brown'])
            //     ->default(config('admin.layout.color'));

            // $this->radio('admin_layout_navbar-color', __('dashboard-settings.nav_bar_color'))
            //     ->options(['' =>'Default', 'bg-primary' => 'Primary', 'bg-info' => 'Blue', 'bg-warning' => 'Orange', 'bg-success' => 'Green', 'bg-dark' => 'Dark'])
            //     ->default(config('admin.layout.navbar-color'));

            $this->radio('admin_locale', __('dashboard-settings.locale'))
                ->options(['en' => 'English', 'es' => 'Español', 'pt' => 'Português', 'ja' => 'Japanese'])
                ->default(config('app.locale'));

            $this->number('admin_paginate-default', __('dashboard-settings.paginate_default'))->default(config('admin.paginate-default'));
            // $this->radio('app_locale', __('dashboard-settings.lang'))
            //     ->options(['en' =>'English', 'ru' => 'Russian'])
            //     ->default(config('app.locale'));
        }, false, 'basic');

        $this->tab(__('dashboard-settings.login_n_registration'), function(Form $form) {
            $form->column(6, function(Form $form) {
                $form->switch('admin_allow-register', __('dashboard-settings.allow_register'))->default(config('admin.allow-register'))->width(2, 8);
                $form->switch('admin_registration-activation-enabled', __('dashboard-settings.registration_activation_enabled'))->default(config('admin.registration-activation-enabled'))->width(2, 8);
                $form->switch('admin_allow-reset-password', __('dashboard-settings.allow_reset_password'))->default(config('admin.allow-reset-password'))->width(2, 8);
            });

            $form->column(6, function(Form $form) {
                $form->switch('admin_recaptch-enabled', __('dashboard-settings.recaptch_enabled'))->width(8,4)->width(8,4)->default(config('admin.recaptch-enabled'));
                $form->text('admin_recaptch-site', __('dashboard-settings.recaptch_site'))->width(8,4)->default(config('admin.recaptch-site'));
                $form->text('admin_recaptch-secret', __('dashboard-settings.recaptch_secret'))->width(8,4)->default(config('admin.recaptch-secret'));
            });
        }, false, 'login_n_registration');

        $this->tab(__('dashboard-settings.logos_n_favicons'), function(Form $form) {
            //$form->block()
            $form->column(4, function(Form $form) {
                $form->image('admin_logo-image', __('dashboard-settings.logo'))
                    ->horizontal(false)
                    ->autoUpload()
                    ->uniqueName()
                    ->default(config('admin.logo-image'));

                $form->image('admin_logo-mini', __('dashboard-settings.logo_mini'))
                    ->horizontal(false)
                    ->autoUpload()
                    ->uniqueName()
                    ->default(config('admin.logo-mini'));

            });

            $form->column(4, function(Form $form) {
                $form->image('admin_login-background-image', __('dashboard-settings.login_background_image'))
                    ->horizontal(false)
                    ->autoUpload()
                    ->uniqueName()
                    ->default(config('admin.login-background-image'));

                $form->image('admin_login-image', __('dashboard-settings.login_image'))
                    ->horizontal(false)
                    ->autoUpload()
                    ->uniqueName()
                    ->default(config('admin.login-image'));

            });
            $form->column(4, function(Form $form) {
                $form->image('admin_icons_icon-32', __('dashboard-settings.favicon_icon_32'))
                    ->horizontal(false)
                    ->autoUpload()
                    ->uniqueName()
                    ->default(config('admin.icons.icon-32'));

                $form->image('admin_icons_icon-192', __('dashboard-settings.favicon_icon_192'))
                    ->horizontal(false)
                    ->autoUpload()
                    ->uniqueName()
                    ->default(config('admin.icons.icon-192'));
            });

        }, false, 'logos-and-favicons');

        //todo::fix
        // $this->tab(__('dashboard-settings.custom_style'), function(Form $form) {
        //     $form->codemirror('admin_custom-style', __('dashboard-settings.css'))->mode(CodemirrorMode::CSS)->default(config('admin.custom-style'))->help('Hit F5 button (Refresh page) if you see editor layout is broken');
        // }, false, 'custom-style');

        // $this->tab(__('dashboard-settings.webhooks'), function(Form $form) {
        //     $form->switch('admin_webhooks_enabled', __('dashboard-settings.webhooks_enabled'))->default(config('admin.webhooks.enabled'));
        //     $form->text('admin_webhooks_url', __('dashboard-settings.webhooks_url'))->default(config('admin.webhooks.url'));
        //     $form->text('admin_webhooks_token', __('dashboard-settings.webhooks_token'))->help('Will be sent in Header. Format: "Bearer \'token\'"')->default(config('admin.webhooks.token'));
        // }, false, 'webhooks');


    }
}
