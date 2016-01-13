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
                <form class="navbar-form navbar-right">
                    @if (Auth::check())
                        <a href="{{ route('login::logout') }}" class="btn btn-default btn-danger"><i class="fa fa-lock"></i></a>
                    @else
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#loginModal">
                            <i class="fa fa-unlock-alt"></i>
                        </button>
                    @endif
                </form>

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
            @include('auth/modal');
        @endif

    </body>

</html>