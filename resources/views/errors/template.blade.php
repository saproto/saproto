@extends('website.master')

@section('page-title')
    Whoops!
@endsection

@section('body')

    <div id="error__header">

        <h2>@yield('page-title')</h2>

    </div>

    <div id="error__container" class="col-lg-4 col-lg-offset-4 col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">

        @yield('page-body')

        <p>
            <sub>
                @if(!empty(Sentry::getLastEventID()))
                    This incident has already been reported: #{{ Sentry::getLastEventID() }}
                @else
                    This incident has <strong>not</strong> been reported.
                @endif
            </sub>
        </p>

        <p style="text-align: center">
            <img id="error__logo" src="{{ asset('images/logo/inverse.png') }}" width="150px">
        </p>

        <p style="text-align: center;">
            <br>
            <a href="/" style="color: #fff;">
                <sub>Go back to homepage.</sub>
            </a>
        </p>

    </div>

@endsection

@section('stylesheet')

    @parent

    <style>

        #footer {
            display: none;
        }

    </style>

@endsection