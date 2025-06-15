@extends('website.master')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-12 text-center">
                <div class="card mt-5 mb-3">
                    <div class="card-header bg-dark text-center text-white">
                        S.A. Proto |
                        @yield('page-title')
                    </div>

                    <div class="card-body text-center">
                        @yield('login-body')
                    </div>

                    <a
                        href="/"
                        class="card-footer text-decoration-none text-muted text-center"
                    >
                        Go back to homepage.
                    </a>
                </div>

                <img
                    src="{{ asset('images/logo/regular.png') }}"
                    width="60%"
                    class="mt-5 mb-3"
                    alt="Proto logo"
                />
            </div>
        </div>
    </div>
@endsection
