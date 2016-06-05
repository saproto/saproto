<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>S.A. Proto | @yield('page-title','Default Page Title')</title>

    @include('website.layouts.assets.stylesheets')

    @section('stylesheet')
        @include('website.layouts.assets.customcss')
    @show

</head>

<body ng-controller="AppController as app" style="display: block;">

<div id="wrap">

    <div id="main">

        @yield('body')

    </div>

</div>

<footer id="footer">
    <div class="container">
        <div class="row vcard">
            <div class="col-md-2 col-xs-6">
                <strong>
                    <span class="fa fa-home"></span>&nbsp;&nbsp;
                    <span class="org url" href="http://www.kick-in.nl/"><span
                                class="green">S.A. Proto</span></span>
                </strong>
                <br>
                <span class="adr">
                    <span class="extended-address">Zilverling A230</span><br>
                    <span class="street-address">Drienerlolaan 5</span><br>
                    <span class="postal-code">7522NB</span>
                    <span class="locality">Enschede</span><br>
                </span>
            </div>
            <div class="col-md-3 col-xs-6">
                <br>
                <span class="fa fa-clock-o"></span>&nbsp;&nbsp;Mon-Fri, 09:30-16:30<br>
                <span class="fa fa-phone"></span>&nbsp;&nbsp;<a class="tel white" href="tel:+31534894423">+31 (0)53 489
                    4423</a><br>
                <span class="fa fa-paperclip"></span>&nbsp;&nbsp;
                <a class="email white"
                   href="mailto:board@proto.utwente.nl">board@proto.utwente.nl</a>
            </div>
            <div class="col-md-4 col-xs-6">

                &copy; {{ date('Y') }} S.A. Proto. All rights reserved.<br>
                <sub>
                    This website has been created with ♥ by the folks of the <a
                            href="https://www.saproto.nl/developers" class="green" target="_blank">Have You Tried
                        Turning It Off And
                        On Again committee</a> of Study Association Proto. The source is available on <a
                            href="https://github.com/saproto/saproto" class="green" target="_blank">GitHub</a>.
                </sub>
            </div>
            <div class="col-md-3 col-xs-6" style="text-align: right;">
                <img src="{{ asset('images/logo/inverse.png') }}" width="57%">
            </div>
        </div>
    </div>
</footer>

@section('javascript')
    @include('website.layouts.assets.javascripts')
@show

@if($app->environment('staging'))
    @include('website.stagingwarn')
@endif

</body>

</html>
