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
    <meta name="keywords" content="{{ Dcat\Admin\Admin::metaKeywords() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(! empty($favicon = Dcat\Admin\Admin::favicon()))
        {!! $favicon !!}
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    {!! admin_section(Dcat\Admin\Admin::SECTION['HEAD']) !!}

    {!! Dcat\Admin\Admin::asset()->headerJsToHtml() !!}

    {!! Dcat\Admin\Admin::asset()->cssToHtml() !!}
</head>

<body>
    <script>
        var Dcat = CreateDcat({!! Dcat\Admin\Admin::jsVariables() !!});
    </script>
<!-- Content -->
<div class="container-xxl">
    @include('admin::partials.alerts')

    {!! $content !!}

    @include('admin::partials.toastr')
</div>
<!-- / Content -->
{!! Dcat\Admin\Admin::asset()->scriptToHtml() !!}
{!! Dcat\Admin\Admin::asset()->jsToHtml() !!}
</body>
</html>
