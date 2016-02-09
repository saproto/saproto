<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>S.A. Proto | @section('page-title')Default Page Title@show</title>

        @include('website/default/stylesheets')

        @include('website/default/custom')

        @section('stylesheet')
        @show

    </head>

    <body style="display: block;">

        @include('website/default/javascripts')

        @if (Session::has('flash_message'))
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_message') }}
            </div>
        @endif

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">

                <!--
                    Navbar header. The part where the icon and name and shit is.
                //-->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('homepage') }}">S.A. Proto</a>
                </div>

                <!--
                    The auth and logout shit.
                //-->
                    @if (Auth::check())
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('profile::editOwn') }}">Preferences</a></li>
                                    <li><a href="{{ route('login::logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    @else
                        <form class="navbar-form navbar-right">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#loginModal">
                                <i class="fa fa-unlock-alt"></i>
                            </button>
                        </form>
                    @endif

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

        @section('content')
        @show

        @if (!Auth::check())
            @include('auth/modal')
        @endif

    </body>

</html>