<body>
<script>
    var Dcat = CreateDcat({!! Dcat\Admin\Admin::jsVariables() !!});
</script>

{!! admin_section(Dcat\Admin\Admin::SECTION['BODY_INNER_BEFORE']) !!}

<div class="layout-wrapper {{ $layout['type'] == Dcat\Admin\Enums\LayoutType::HORIZONTAL ? 'layout-navbar-full layout-horizontal layout-without-menu' : 'layout-content-navbar' }}">
    <div class="layout-container">
        @if($layout['type'] == Dcat\Admin\Enums\LayoutType::HORIZONTAL)
            @include('admin::partials.navbar')
        @else
            @include('admin::partials.sidebar')
        @endif

        <div class="layout-page">
            @if($layout['type'] != Dcat\Admin\Enums\LayoutType::HORIZONTAL)
                @include('admin::partials.navbar')
            @endif
            <div class="content-wrapper">
                @if($layout['type'] == Dcat\Admin\Enums\LayoutType::HORIZONTAL)
                    @include('admin::partials.sidebar')
                @endif
                <div class="app-content">
                    <div class="{{ $layout['content_type'] }} flex-grow-1 container-p-y" id="{{ $pjaxContainerId }}">
                        @yield('app')
                    </div>
                </div>

                @include('admin::partials.footer')
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>

{!! admin_section(Dcat\Admin\Admin::SECTION['BODY_INNER_AFTER']) !!}

{!! Dcat\Admin\Admin::asset()->jsToHtml() !!}
<script>Dcat.boot();</script>
</body>

</html>
