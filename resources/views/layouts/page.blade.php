<!DOCTYPE html>
<html 
lang="{{ Dcat\Admin\Admin::locale() }}" 
class="{{ Dcat\Admin\Admin::darkMode() }} {{ Dcat\Admin\Admin::layoutInitials() }}" 
dir="{{ Dcat\Admin\Admin::dir() }}" 
    data-theme="{{ Dcat\Admin\Admin::theme() }}"
    data-template="vertical-menu-theme-default-dark"
    data-assets-path="/{{ Admin::asset()->getRealPath('@admin') }}/"
    data-base-url="/"
    >
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="{{ Dcat\Admin\Admin::metaDescription() }}" />
    <meta name="keywords" content="{{ Dcat\Admin\Admin::metaKeywords() }}">

    <title>@if(! empty($header)){{ $header }} | @endif {{ Dcat\Admin\Admin::title() }}</title>

    @if(! config('admin.disable_no_referrer_meta'))
        <meta name="referrer" content="no-referrer"/>
    @endif

    @if(! empty($favicon = Dcat\Admin\Admin::favicon()))
        {!! $favicon !!}
    @endif

    {!! admin_section(Dcat\Admin\Admin::SECTION['HEAD']) !!}

    {!! Dcat\Admin\Admin::asset()->headerJsToHtml() !!}

    {!! Dcat\Admin\Admin::asset()->cssToHtml() !!}

</head>

@extends('admin::layouts.container')
