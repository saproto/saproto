<!DOCTYPE html>
<html lang="en" class="position-relative mh-100">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <meta name="theme-color" content="#C1FF00">

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>
    <link rel="search" type="application/opensearchdescription+xml" title="S.A. Proto"
          href="{{ route('search::opensearch') }}"/>
    <script src="https://kit.fontawesome.com/63e98a7060.js" crossorigin="anonymous"></script>

    <title>@if(config('app.env') != 'production') [{{ strtoupper(config('app.env')) }}] @endif S.A. Proto
        | @yield('page-title','Default Page Title')</title>

    @stack('head')

    @include('website.layouts.assets.stylesheets')

    @stack('stylesheet')

    @section('opengraph')
        <meta property="og:url" content="{{ Request::url() }}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="@yield('page-title','Website')"/>
        <meta property="og:description"
              content="@yield('og-description','S.A. Proto is the study association for Creative Technology at the University of Twente.')"/>
        <meta property="og:image"
              content="@yield('og-image',asset('images/logo/og-image.png'))"/>
    @show

</head>

<body class="template-{{ $viewName }}">

@yield('body')

@include('discord.modal')

@if(!App::isDownForMaintenance())

    @include('website.layouts.macros.flashmessages')

    @include('website.layouts.macros.achievement-popup')

    @include('website.layouts.macros.errormessages')

    @include('website.layouts.assets.javascripts')
    <!-- Page scripts -->
    @stack('javascript')

@endif

</body>

</html>
