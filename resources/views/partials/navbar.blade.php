<!-- todo::split on two files -->
{!! admin_section(Dcat\Admin\Admin::SECTION['NAVBAR_BEFORE']) !!}

<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme {{ $layout['type'] == Dcat\Admin\Enums\LayoutType::HORIZONTAL() ? '' : $layout['content_type'] }} "
    id="layout-navbar">
    @if($layout['type'] == Dcat\Admin\Enums\LayoutType::HORIZONTAL())
    <div class="container-xxl">
        <div class="navbar-brand app-brand d-none d-xl-flex py-0 me-4">
            <a href="{{ admin_route(\Dcat\Admin\Enums\RouteAuth::SETTINGS()) }}" class="app-brand-link gap-2">
                <span class="app-brand-logo">
                    <img src="{!! config('admin.logo-image') !!}" alt="" class="app-brand-img w-px-150" data-app-light-img="{!! config('admin.logo-image') !!}" data-app-dark-img="{!! config('admin.logo-image-dark') !!}">
                </span>
                <span class="app-brand-text menu-text fw-bold">{{ config('admin.name') }}</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>
    @endif
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            {!! Dcat\Admin\Admin::navbar()->renderFree() !!}
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                {!! Dcat\Admin\Admin::navbar()->renderNavs() !!}
                <!-- User -->
                {!! admin_section(Dcat\Admin\Admin::SECTION['NAVBAR_BEFORE_USER_PANEL']) !!}
                @include('admin::widgets.user-nav', ['user' => \Dcat\Admin\Admin::user()])
                {!! admin_section(Dcat\Admin\Admin::SECTION['NAVBAR_AFTER_USER_PANEL']) !!}
                <!--/ User -->
            </ul>
        </div>
    @if($layout['type'] == Dcat\Admin\Enums\LayoutType::HORIZONTAL)
    </div>
    @endif
</nav>

{!! admin_section(Dcat\Admin\Admin::SECTION['NAVBAR_AFTER']) !!}
