@extends('website.master')

@section('body')

    <div class="container">

        <div id="auth__container" class="row justify-content-center align-self-center">

            <div class="col col-sm-12 col-lg-4">

                <h2>@yield('page-title')</h2>

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

        </div>

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