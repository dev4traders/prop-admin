<!DOCTYPE html>
<html lang="{{ Dcat\Admin\Admin::locale() }}" class="{{ Dcat\Admin\Admin::darkMode() }} {{ Dcat\Admin\Admin::layoutInitials() }}" dir="{{ Dcat\Admin\Admin::dir() }}" data-theme="{{ Dcat\Admin\Admin::theme() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@if(! empty($header)){{ $header }} | @endif {{ Dcat\Admin\Admin::title() }}</title>
    @if(config('admin.meta.disable_referrer'))
        <meta name="referrer" content="no-referrer"/>
    @endif

    <meta name="description" content="{{ Dcat\Admin\Admin::metaDescription() }}" />
    <meta name="keywords" content="{{ Dcat\Admin\Admin::metaDescription() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(! empty($favicon = Dcat\Admin\Admin::favicon()))
        {!! $favicon !!}
    @endif

    {!! admin_section(Dcat\Admin\Admin::SECTION['HEAD']) !!}

    {!! Dcat\Admin\Admin::asset()->headerJsToHtml() !!}

    {!! Dcat\Admin\Admin::asset()->cssToHtml() !!}
</head>

<body>
    <script>
        var Dcat = CreateDcat({!! Dcat\Admin\Admin::jsVariables() !!});
    </script>

    {!! admin_section(Dcat\Admin\Admin::SECTION['BODY_INNER_BEFORE']) !!}

    <div id="@if(isset($pjaxContainerId)){{ $pjaxContainerId }}@endif" class="container-xxl">
        @yield('app')
    </div>

    {!! admin_section(Dcat\Admin\Admin::SECTION['BODY_INNER_AFTER']) !!}

    {!! Dcat\Admin\Admin::asset()->jsToHtml() !!}
    <script>Dcat.boot();</script>
</body>
</html>
