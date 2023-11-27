<?php

namespace Dcat\Admin;

use Closure;
use App\Impersonate;
use Dcat\Admin\Layout\Menu;
use Illuminate\Support\Arr;
use Dcat\Admin\Layout\Footer;
use Dcat\Admin\Layout\Navbar;
use Dcat\Admin\Models\Domain;
use Dcat\Admin\Extend\Manager;
use Dcat\Admin\Layout\UserNav;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Traits\HasHtml;
use Dcat\Admin\Enums\RouteAuth;
use Dcat\Admin\Support\Context;
use Dcat\Admin\Support\Setting;
use Dcat\Admin\Enums\LayoutType;
use Dcat\Admin\Support\Composer;
use Dcat\Admin\Traits\HasAssets;
use Dcat\Admin\Http\JsonResponse;
use Illuminate\Auth\GuardHelpers;
use Composer\Autoload\ClassLoader;
use Dcat\Admin\Enums\DarkModeType;
use Dcat\Admin\Support\Translator;
use Dcat\Admin\Contracts\Repository;
use Dcat\Admin\Enums\AuthLayoutType;
use Illuminate\Support\Facades\Auth;
use Dcat\Admin\Layout\SectionManager;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Support\Facades\Event;
use Dcat\Admin\Extend\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Enums\LayoutDirectionType;
use Illuminate\Database\Eloquent\Builder;
use Dcat\Admin\Contracts\ExceptionHandler;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Dcat\Admin\Http\Controllers\AuthController;
use Dcat\Admin\Repositories\EloquentRepository;
use Dcat\Admin\Traits\HasDashboardNotifications;
use Dcat\Admin\Exception\InvalidArgumentException;
use Dcat\Admin\Contracts\EmailContextObjectInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Dcat\Admin\Http\Controllers\DashboardSettingsController;

class Admin
{
    use HasAssets;
    use HasHtml;

    const VERSION = '2.2.2-beta';

    const SECTION = [
        'HEAD' => 'ADMIN_HEAD',

        'BODY_INNER_BEFORE' => 'ADMIN_BODY_INNER_BEFORE',
        'BODY_INNER_AFTER' => 'ADMIN_BODY_INNER_AFTER',

        'APP_INNER_BEFORE' => 'ADMIN_APP_INNER_BEFORE',
        'APP_INNER_AFTER' => 'ADMIN_APP_INNER_AFTER',

        'NAVBAR_BEFORE_USER_PANEL' => 'ADMIN_NAVBAR_BEFORE_USER_PANEL',
        'NAVBAR_AFTER_USER_PANEL' => 'ADMIN_NAVBAR_AFTER_USER_PANEL',

        'NAVBAR_BEFORE' => 'ADMIN_NAVBAR_BEFORE',

        'NAVBAR_AFTER' => 'ADMIN_NAVBAR_AFTER',


        'LEFT_SIDEBAR_USER_PANEL' => 'ADMIN_LEFT_SIDEBAR_USER_PANEL',

        'LEFT_SIDEBAR_MENU' => 'ADMIN_LEFT_SIDEBAR_MENU',

        'LEFT_SIDEBAR_MENU_TOP' => 'ADMIN_LEFT_SIDEBAR_MENU_TOP',

        'LEFT_SIDEBAR_MENU_BOTTOM' => 'ADMIN_LEFT_SIDEBAR_MENU_BOTTOM',
    ];

    public CONST CONTENT_INITIAL_MENU_COLLAPSED = 'layout-menu-collapsed';
    public CONST CONTENT_INITIAL_MENU_FIXED = 'layout-menu-fixed';
    public CONST CONTENT_INITIAL_NAV_FIXED = 'layout-navbar-fixed';
    public CONST CONTENT_INITIAL_FOOTER_FXED = 'layout-footer-fixed';

    private static string $defaultPjaxContainerId = 'pjax-container';

    public static function longVersion() : string
    {
        return sprintf('Dcat Admin <comment>version</comment> <info>%s</info>', static::VERSION);
    }

    public static function color() : Color
    {
        return app('admin.color');
    }

    public static function impersonate() : Impersonate
    {
        return app('admin.impersonate');
    }

    public static function menu(Closure $builder = null) : Menu
    {
        $menu = app('admin.menu');

        $builder && $builder($menu);

        return $menu;
    }

    public static function title($title = null) : string
    {
        if ($title === null) {
            return static::context()->metaTitle ?: config('admin.title');
        }

        return static::context()->metaTitle = $title;
    }

    public static function favicon() : string
    {

        // <link rel="icon" type="image/png" sizes="32x32" href="/storage/img/icon-32.png">
        // <link rel="icon" href="/storage/img/icon-192.png" sizes="192x192" />
        // <link rel="apple-touch-icon" href="/storage/img/icon-192.png" />
        // <meta name="msapplication-TileImage" content="/storage/img/icon-192.png" />
        // <meta name="msapplication-TileColor" content="#ff0000">
        // <link rel="manifest" href="/manifest.json">

        // if ($favicon === null) {
        //     return static::context()->favicon ?: config('admin.favicon');
        // }

        // static::context()->favicon = $favicon;

        $link = '';
        if(!empty($icon32 = config('admin.icons.icon-32'))) {
            $link .= "<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"{$icon32}\">";
        }

        if(!empty($icon192 = config('admin.icons.icon-192'))) {
            $link .= "<link rel=\"icon\" type=\"image/png\" sizes=\"192x192\" href=\"{$icon192}\">";
            $link .= "<link rel=\"apple-touch-icon\" href=\"{$icon192}\" />";
            $link .= "<meta name=\"msapplication-TileImage\" content=\"{$icon192}\" />";
            $link .= "<meta name=\"msapplication-TileColor\" content=\"#ff0000\">";
        }

        return $link;
    }

    public static function translation(?string $path) : void
    {
        static::context()->translation = $path;
    }

    public static function user() : Model|Authenticatable|HasPermissions|EmailContextObjectInterface|HasDashboardNotifications|null
    {
        return static::guard()->user();
    }

    public static function id() : int|string|null
    {
        return static::guard()->id();
    }

    public static function guard() : \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard|GuardHelpers
    {
        return Auth::guard(config('admin.auth.guard') ?: 'admin');
    }

    public static function footer(Closure $builder = null) : Footer
    {
        $footer = app('admin.footer');

        $builder && $builder($footer);

        return $footer;
    }

    public static function navbar(Closure $builder = null) : Navbar
    {
        $navbar = app('admin.navbar');

        $builder && $builder($navbar);

        return $navbar;
    }

    public static function userNav(Closure $builder = null) : UserNav
    {
        $userNav = app('admin.usernav');

        $builder && $builder($userNav);

        return $userNav;
    }

    public static function pjax(bool $value = true) : void
    {
        static::context()->pjaxContainerId = $value ? static::$defaultPjaxContainerId : false;
    }

    public static function disablePjax() : void
    {
        static::pjax(false);
    }

    /**
     * 获取pjax ID.
     *
     * @return string|void
     */
    public static function getPjaxContainerId()
    {
        $id = static::context()->pjaxContainerId;

        if ($id === false) {
            return;
        }

        return $id ?: static::$defaultPjaxContainerId;
    }

    public static function section(Closure $builder = null) : SectionManager
    {
        $manager = app('admin.sections');

        $builder && $builder($manager);

        return $manager;
    }

    public static function setting() : Setting
    {
        return app('admin.setting');
    }

    public static function repository( string|Repository|Model|Builder $repository, array $args = []) : Repository
    {
        if (is_string($repository)) {
            $repository = new $repository($args);
        }

        if ($repository instanceof Model || $repository instanceof Builder) {
            $repository = EloquentRepository::make($repository);
        }

        if (! $repository instanceof Repository) {
            $class = is_object($repository) ? get_class($repository) : $repository;

            throw new InvalidArgumentException("The class [{$class}] must be a type of [".Repository::class.'].');
        }

        return $repository;
    }

    public static function app() : Application
    {
        return app('admin.app');
    }

    public static function domain() : Domain
    {
        return app('admin.domain');
    }

    /**
     * 处理异常.
     *
     * @param  \Throwable  $e
     * @return mixed
     */
    public static function handleException(\Throwable $e)
    {
        /** @var mixed $handler */
        $handler = app(ExceptionHandler::class);
        return $handler->handle($e);
    }

    /**
     * 上报异常.
     *
     * @param  \Throwable  $e
     * @return mixed
     */
    public static function reportException(\Throwable $e)
    {
        return app(ExceptionHandler::class)->report($e);
    }

    /**
     * 显示异常信息.
     *
     * @param  \Throwable  $e
     * @return mixed
     */
    public static function renderException(\Throwable $e)
    {
        return app(ExceptionHandler::class)->render($e);
    }

    /**
     * @param  callable  $callback
     */
    public static function booting($callback) : void
    {
        Event::listen('admin:booting', $callback);
    }

    /**
     * @param  callable  $callback
     */
    public static function booted($callback) : void
    {
        Event::listen('admin:booted', $callback);
    }

    /**
     * @return void
     */
    public static function callBooting() : void
    {
        Event::dispatch('admin:booting');
    }

    /**
     * @return void
     */
    public static function callBooted() : void
    {
        Event::dispatch('admin:booted');
    }

    public static function context() : Context
    {
        return app('admin.context');
    }

    public static function translator() : Translator
    {
        return app('admin.translator');
    }

    /**
     * @param  array|string  $name
     * @return void
     */
    public static function addIgnoreQueryName($name) : void
    {
        $context = static::context();

        $ignoreQueries = $context->ignoreQueries ?? [];

        $context->ignoreQueries = array_merge($ignoreQueries, (array) $name);
    }

    public static function getIgnoreQueryNames() : array
    {
        return static::context()->ignoreQueries ?? [];
    }

    public static function prevent(string|Renderable|\Closure $value)
    {
        if ($value !== null) {
            static::context()->add('contents', $value);
        }
    }

    /**
     * @return bool
     */
    public static function shouldPrevent()
    {
        return count(static::context()->getArray('contents')) > 0;
    }

    /**
     * 渲染内容.
     *
     * @return string|void
     */
    public static function renderContents()
    {
        if (! static::shouldPrevent()) {
            return;
        }

        $results = '';

        foreach (static::context()->getArray('contents') as $content) {
            $results .= Helper::render($content);
        }

        // 等待JS脚本加载完成
        static::script('Dcat.wait()', true);

        $asset = static::asset();

        static::baseCss([], false);
        static::baseJs([], false);
        static::headerJs([], false);
        static::fonts([]);

        return $results
            .static::html()
            .$asset->jsToHtml()
            .$asset->cssToHtml()
            .$asset->scriptToHtml()
            .$asset->styleToHtml();
    }

    public static function json(array $data = []) : JsonResponse
    {
        return JsonResponse::make($data);
    }

    public static function extension(?string $name = null) : Manager|ServiceProvider|null
    {
        if ($name) {
            return app('admin.extend')->get($name);
        }

        return app('admin.extend');
    }

    /**
     * @throws HttpResponseException
     */
    public static function exit(Response|string|array $response = '')
    {
        if (is_array($response)) {
            $response = response()->json($response);
        } elseif ($response instanceof JsonResponse) {
            $response = $response->send();
        }

        throw new HttpResponseException($response instanceof Response ? $response : response($response));
    }

    public static function classLoader() : ClassLoader
    {
        return Composer::loader();
    }

    public static function mixMiddlewareGroup(array $mix = []) : void
    {
        $router = app('router');

        $group = $router->getMiddlewareGroups()['admin'] ?? [];

        if ($mix) {
            $finalGroup = [];

            foreach ($group as $i => $mid) {
                $next = $i + 1;

                $finalGroup[] = $mid;

                if (! isset($group[$next]) || $group[$next] !== 'admin.permission') {
                    continue;
                }

                $finalGroup = array_merge($finalGroup, $mix);

                $mix = [];
            }

            if ($mix) {
                $finalGroup = array_merge($finalGroup, $mix);
            }

            $group = $finalGroup;
        }

        $router->middlewareGroup('admin', $group);
    }

    /**
     * 获取js配置.
     *
     * @param  array|null  $variables
     * @return string
     */
    public static function jsVariables(array $variables = null)
    {
        $jsVariables = static::context()->jsVariables ?: [];

        if ($variables !== null) {
            static::context()->jsVariables = array_merge(
                $jsVariables,
                $variables
            );

            return;
        }

        $sidebarStyle = config('admin.layout.sidebar_style') ?: 'light';

        $pjaxId = static::getPjaxContainerId();
        $jsVariables['pjax_container_selector'] = $pjaxId ? ('#'.$pjaxId) : '';
        $jsVariables['token'] = csrf_token();
        $jsVariables['lang'] = ($lang = __('admin.client')) ? array_merge($lang, $jsVariables['lang'] ?? []) : [];
        //todo::rm
        //$jsVariables['colors'] = static::color()->all();
        // $jsVariables['dark_mode'] = static::isDarkMode();
        // $jsVariables['sidebar_dark'] = config('admin.layout.sidebar_dark') || ($sidebarStyle === 'dark');
        // $jsVariables['sidebar_light_style'] = in_array($sidebarStyle, ['dark', 'light'], true) ? 'sidebar-light-primary' : 'sidebar-primary';

        return admin_javascript_json($jsVariables);
    }

    public static function locale() : string {
        return str_replace('_', '-', app()->getLocale());
    }

    public static function dir() : LayoutDirectionType {
        return config('admin.layout.dir');
    }

    public static function layoutInitials() : string {
        return Arr::join(config('admin.layout.initials'), ' ');
    }

    public static function metaDescription() : string {
        return config('admin.meta.description') ? config('admin.meta.description') : '';
    }

    public static function metaKeywords() : string {
        return config('admin.meta.keywords') ? config('admin.meta.keywords') : '';
    }

    public static function theme() : string {
        return config('admin.theme');
    }

    public static function darkMode() : DarkModeType {
        return config('admin.layout.dark_mode');
    }

    public static function authLayoutType() : AuthLayoutType {
        return config('admin.layout.auth_type');
    }

    public static function layoutType() : LayoutType {
        return config('admin.layout.type');
    }

    //todo:clean and rm
    /**
     * @return bool
     */
    public static function isDarkMode()
    {
        $bodyClass = config('admin.layout.body_class');

        return in_array(
            'dark-mode',
            is_array($bodyClass) ? $bodyClass : explode(' ', $bodyClass),
            true
        );
    }

    /**
     * 注册路由.
     *
     * @return void
     */
    public static function routes() : void
    {
        $attributes = [
            'prefix'     => config('admin.route.prefix'),
            'middleware' => config('admin.route.middleware'),
        ];

        if (config('admin.auth.enable', true)) {
            app('router')->group($attributes, function ($router) {
                /* @var \Illuminate\Routing\Router $router */
                $router->namespace('Dcat\Admin\Http\Controllers')->group(function ($router) {
                    /* @var \Illuminate\Routing\Router $router */
                    $router->resource('auth/users', 'UserController');
                    $router->resource('auth/menu', 'MenuController', ['except' => ['create', 'show']]);
                    $router->resource('auth/domains', 'DomainController');
                    $router->resource('auth/domain-menu', 'DomainMenuController');

                    if (config('admin.permission.enable')) {
                        $router->resource('auth/roles', 'RoleController');
                        $router->resource('auth/permissions', 'PermissionController');
                    }
                });

                $router->resource('auth/extensions', 'Dcat\Admin\Http\Controllers\ExtensionController', ['only' => ['index', 'store', 'update']]);
                $router->get('dashboard-settings', function (\Dcat\Admin\Layout\Content $content) {
                    return (new DashboardSettingsController())->index($content);
                })->name(RouteAuth::DASH_SETTINGS());

                $authController = config('admin.auth.controller', AuthController::class);

                $router->get('auth/login', $authController.'@getLogin')->name(RouteAuth::LOGIN());
                $router->post('auth/login', $authController.'@postLogin');
                $router->get('auth/logout', $authController.'@getLogout')->name(RouteAuth::LOGOUT());
                $router->get('auth/setting', $authController.'@getSetting')->name(RouteAuth::SETTINGS());
                $router->put('auth/setting', $authController.'@putSetting');
                $router->get('auth/impersonate/{id}', $authController.'@impersonate')->name(RouteAuth::IMPERSONATE());
                $router->get('auth/deimpersonate', $authController.'@deimpersonate')->name(RouteAuth::DEIMPERSONATE());

                $router->get('auth/forgot-password', $authController.'@getForgotPassword')->name(RouteAuth::FORGOT_PASSWORD());
                $router->get('auth/register', $authController.'@getRegister')->name(RouteAuth::REGISTER());

                $router->get('locale/{key}', $authController.'@setLocale')->name('set-locale');
            });
        }

        if (config('admin.dashboard_settings.enable', true)) {

            app('router')->group($attributes, function ($router) {
                $router->get('dashboard-settings', function (\Dcat\Admin\Layout\Content $content) {
                    return (new DashboardSettingsController())->index($content);
                })->name(RouteAuth::DASH_SETTINGS());
            });
        }

        static::registerHelperRoutes();
    }

    //todo:: add auth routes: login/register/reset pwd,verify
    public static function registerApiRoutes() : void
    {
        $attributes = [
            'prefix'     => admin_base_path('dcat-api'),
            'middleware' => config('admin.route.middleware'),
            'namespace'  => 'Dcat\Admin\Http\Controllers',
            'as'         => 'dcat-api.',
        ];

        app('router')->group($attributes, function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            $router->post('action', 'HandleActionController@handle')->name('action');
            $router->post('form', 'HandleFormController@handle')->name('form');
            $router->post('form/upload', 'HandleFormController@uploadFile')->name('form.upload');
            $router->post('form/destroy-file', 'HandleFormController@destroyFile')->name('form.destroy-file');
            $router->post('value', 'ValueController@handle')->name('value');
            $router->get('render', 'RenderableController@handle')->name('render');
            $router->post('tinymce/upload', 'TinymceController@upload')->name('tinymce.upload');
            $router->post('editor-md/upload', 'EditorMDController@upload')->name('editor-md.upload');
        });
    }

    public static function registerHelperRoutes() : void
    {
        if (! config('admin.helpers.enable', true) || ! config('app.debug')) {
            return;
        }

        $attributes = [
            'prefix'     => config('admin.route.prefix'),
            'middleware' => config('admin.route.middleware'),
        ];

        app('router')->group($attributes, function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            $router->get('helpers/scaffold', 'Dcat\Admin\Http\Controllers\ScaffoldController@index');
            $router->post('helpers/scaffold', 'Dcat\Admin\Http\Controllers\ScaffoldController@store');
            $router->post('helpers/scaffold/table', 'Dcat\Admin\Http\Controllers\ScaffoldController@table');
            $router->get('helpers/icons', 'Dcat\Admin\Http\Controllers\IconController@index');
        });
    }
}
