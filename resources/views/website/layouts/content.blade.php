@extends('website.master')

@section('body')

    @include('website.navigation.navbar')

    <div id="header">

        <div class="container">

            <h1>
                <span>
                    <strong>@yield('page-title')</strong>
                </span>
            </h1>

        </div>

    </div>

    @yield('container')

@endsection