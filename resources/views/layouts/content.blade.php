@section('content-header')
@if($header || $description)
    <h4 class="py-3 mb-4">
        @if($header)<span class="text-muted fw-light">{!! $header !!} / </span>@endif{!! $description !!}
    </h4>
@endif
@if($breadcrumb || config('admin.enable_default_breadcrumb'))
    @include('admin::partials.breadcrumb')
@endif
@endsection

@section('content')
    @include('admin::partials.alerts')
    {!! $content !!}

    @include('admin::partials.toastr')
@endsection

@section('app')
    {!! Dcat\Admin\Admin::asset()->styleToHtml() !!}

    <div class="content-header">
        @yield('content-header')
    </div>

    <div class="content-body" id="app">
        {!! admin_section(Dcat\Admin\Admin::SECTION['APP_INNER_BEFORE']) !!}

        @yield('content')

        {!! admin_section(Dcat\Admin\Admin::SECTION['APP_INNER_AFTER']) !!}
    </div>

    {!! Dcat\Admin\Admin::asset()->scriptToHtml() !!}
    <div class="extra-html">{!! Dcat\Admin\Admin::html() !!}</div>
@endsection

@if(! request()->pjax())
    @include('admin::layouts.page')
@else
    <title>{{ Dcat\Admin\Admin::title() }} @if($header) | {{ $header }}@endif</title>

    {!! Dcat\Admin\Admin::asset()->cssToHtml() !!}
    {!! Dcat\Admin\Admin::asset()->jsToHtml() !!}

    @yield('app')
@endif
