@extends('website.master')

@section('body')

    <div class="row justify-content-center">

        <div class="col-xl-3 col-lg-5 col-md-6 col-sm-10 col-xs-12">

            <div class="card mb-3" style="margin-top: 50px;">

                <div class="card-header text-center bg-dark text-white">
                    @yield('page-title')
                </div>

                <div class="card-body text-center">

                    <img src="{{ asset('images/logo/regular.png') }}" width="50%">

                    <hr>

                    @yield('login-body')

                </div>

                <a href="/" style="text-decoration: none !important;" class="card-footer text-muted text-center">
                    Go back to homepage.
                </a>

            </div>

        </div>

    </div>

    <div id="auth__header">

        <h2></h2>

    </div>

    <div id="auth__container" class="">

        <p style="text-align: center;">
            <br>

        </p>

    </div>

@endsection

@section('stylesheet')

    @parent

    <style>

        footer {
            display: none;
        }

    </style>

@endsection