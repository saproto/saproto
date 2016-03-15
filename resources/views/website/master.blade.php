<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>S.A. Proto | @yield('page-title','Website')
    </title>

    @include('website.layouts.assets.stylesheets')

    <style type="text/css">
        @section('stylesheet')
            @include('website.layouts.assets.customcss')
        @show
    </style>

</head>

<body style="display: block;">

@include('website.layouts.assets.javascripts')

@yield('body')

</body>

</html>