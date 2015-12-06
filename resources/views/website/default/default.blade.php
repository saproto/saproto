<!DOCTYPE html>
<html>

    <head>

        <title>S.A. Proto | @section('page-title')Default Page Title@show</title>

        @include('website/default/stylesheets')

        @include('website/default/custom')

        @section('stylesheet')
        @show

    </head>

    <body style="display: block;">

        @include('website/default/javascripts')

        <div class="navbar-fixed">
            <nav>
                <div id="main-navigation" class="nav-wrapper light-green">
                    <a href="{{ route('homepage') }}" class="brand-logo">S.A. Proto</a>
                    <a href="#" data-activates="mobile-navbar" class="button-collapse"><i class="material-icons">menu</i></a>
                    <div id="authentication" class="right hide-on-med-and-down">
                        @if (Auth::check())
                            <a class="waves-effect waves-light btn white light-green-text" href="{{ route('login::logout') }}"><i class="fa fa-lock right"></i>logout</a>
                        @else
                            <a class="waves-effect waves-light btn white light-green-text" href="{{ route('login::show') }}"><i class="fa fa-key right"></i>login</a>
                        @endif
                    </div>
                    <ul class="right hide-on-med-and-down">
                        @include('website/navigation/navbar')
                    </ul>
                    <ul class="side-nav" id="mobile-navbar">
                        @include('website/navigation/navbar')
                    </ul>
                </div>
            </nav>
        </div>

        <p>
            &nbsp;
        </p>

        @section('content')
        @show

    </body>

</html>