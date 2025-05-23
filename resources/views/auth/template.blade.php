@extends('website.master')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-5 text-center">
                <div class="card mb-3 mt-5">
                    <div class="card-header bg-dark text-center text-white">
                        S.A. Proto |
                        @yield('page-title')
                    </div>

                    <div class="card-body text-center">
                        @yield('login-body')
                    </div>

                    <a
                        href="/"
                        class="card-footer text-decoration-none text-center text-muted"
                    >
                        Go back to homepage.
                    </a>
                </div>

                <img
                    src="{{ asset('images/logo/regular.png') }}"
                    width="60%"
                    class="mb-3 mt-5"
                    alt="Proto logo"
                />
            </div>
        </div>
    </div>
@endsection
