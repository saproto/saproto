<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>S.A. Proto |
        @section('page-title')
            Default Page Title
        @show
    </title>

    @include('website/default/stylesheets')

    @include('website/default/custom')

    @section('stylesheet')
    @show

</head>

<body style="display: block;">

@include('website/default/javascripts')


<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">

        <!--
            Navbar header. The part where the icon and name and shit is.
        //-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('homepage') }}">{{ config("association.name") }}</a>
        </div>

        <!--
            The actual navbar contents with links to pages and tools and shit.
        //-->
        <ul class="nav navbar-nav navbar-right">
            @include('website/navigation/navbar')
        </ul>

    </div>
</nav>

<p>
    &nbsp;
</p>

<div class="container">
    @if (Session::has('flash_message'))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('flash_message') }}
        </div>
    @endif

    @foreach($errors->all() as $e)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ $e }}
        </div>
    @endforeach
</div>

@section('content')
@show

@if (!Auth::check())
    @include('auth/modal')
@endif

</body>

</html>