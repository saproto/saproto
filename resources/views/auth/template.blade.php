@extends('website.master')

@section('body')

    <div id="auth__header">

        <h2>@yield('page-title')</h2>

    </div>

    <div id="auth__container" class="col-lg-2 col-lg-offset-5 col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">

        <p style="text-align: center">
            <img id="auth__logo" src="{{ asset('images/logo/inverse.png') }}" width="150px">
        </p>

        @yield('login-body')

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