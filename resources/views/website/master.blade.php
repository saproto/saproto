<!DOCTYPE html>
<html lang="en" style="position: relative; min-height: 100%;">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <meta name="theme-color" content="#C1FF00">

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>
    <link rel="search" type="application/opensearchdescription+xml" title="S.A. Proto"
          href="{{ route('search::opensearch') }}"/>

    <title>@if(config('app.env') != 'production') [DEV] @endif S.A. Proto
        | @yield('page-title','Default Page Title')</title>

    @section('head')
    @show

    @include('website.layouts.assets.stylesheets')

    @section('stylesheet')
        @include('website.layouts.assets.customcss')
    @show

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

<body class="template-{{ $viewName }}" style="background-color: #e0e0e0; margin-bottom: 216px;">

@yield('body')

@if(!App::isDownForMaintenance())

@section('javascript')
    @include('website.layouts.assets.javascripts')
@show

@if (Session::has('flash_message'))

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

@if (isset($errors) && count($errors->all()) > 0)

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

@include('slack.modal')

</body>

</html>
