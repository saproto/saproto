<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <meta name="theme-color" content="#C1FF00">

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>
    <link rel="search" type="application/opensearchdescription+xml" title="S.A. Proto"
          href="{{ route('search::opensearch') }}"/>

    <title>S.A. Proto | @yield('page-title','Default Page Title')</title>

    @include('website.layouts.assets.stylesheets')

    @section('stylesheet')
        @include('website.layouts.assets.customcss')
    @show

    @section('opengraph')
        <meta property="og:url" content="{{ Request::url() }}"/>
        <meta property="og:type" content="website"/>
        <meta property="fb:app_id" content="145272648862427"/>
        <meta property="og:title" content="@yield('page-title','Website')"/>
        <meta property="og:description"
              content="@yield('og-description','S.A. Proto is the study association for Creative Technology at the University of Twente.')"/>
        <meta property="og:image"
              content="@yield('og-image',asset('images/logo/og-image.png'))"/>
    @show

</head>

<body ng-controller="AppController as app" style="display: block;">

<div id="wrap">

    <div id="main">

        @yield('body')

    </div>

</div>

@include('website.navigation.navbar')

<footer class="main-footer" id="footer">
    <div class="container">
        <div class="row vcard">
            <div class="col-md-2 col-xs-6">
                <strong>
                    <span class="fa fa-home"></span>&nbsp;&nbsp;
                    <span class="org url" href="https://www.saproto.nl/"><span
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
                    This website has been created with ♥ by the folks of the
                    <a href="{{ route('developers') }}" class="green">
                        {{ Committee::where('slug', '=', config('proto.rootcommittee'))->first()->name }}
                    </a>.
                    The source is available on
                    <a href="https://github.com/saproto/saproto" class="green" target="_blank">GitHub</a>.
                </sub>
            </div>
            <div class="col-md-3 col-xs-6 footer__logo">
                <img src="{{ asset('images/logo/inverse.png') }}" width="57%">
            </div>
        </div>
    </div>
</footer>

@if(!App::isDownForMaintenance())

@section('javascript')
    @include('website.layouts.assets.javascripts')
@show

@if (Session::has('flash_message'))

    <!-- Modal -->
    <div class="modal fade" id="flashModal" tabindex="-1" role="dialog" aria-labelledby="flashModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="flashModalLabel">Attention</h4>
                </div>
                <div class="modal-body">
                    {!! Session::get('flash_message') !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#flashModal').modal('show');
    </script>

@endif

@if (count($errors->all()) > 0)

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="errorModalLabel">Error</h4>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#errorModal').modal('show');
    </script>

@endif

@endif

</body>

</html>
