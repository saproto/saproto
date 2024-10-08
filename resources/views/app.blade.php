<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}" />
    <link rel="search" type="application/opensearchdescription+xml" title="S.A. Proto"
          href="{{ route('search::opensearch') }}" />


    <!-- Scripts -->
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @routes(nonce: csp_nonce())
    @inertiaHead

    @section('opengraph')
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="@yield('page-title','Website')" />
        <meta property="og:description"
              content="@yield('og-description','S.A. Proto is the study association for Creative Technology at the University of Twente.')" />
        <meta property="og:image"
              content="@yield('og-image',asset('images/logo/og-image.png'))" />
    @show

</head>
<body class="font-sans antialiased" data-theme='{{config('proto.themes')[Auth::user()?->theme??0]}}'>
<script src="{{ config('proto.fontawesome_kit') }}" crossorigin="anonymous"></script>
@inertia
</body>
</html>
