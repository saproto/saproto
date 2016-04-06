@extends('website.master')

@section('header')

    <div id="header">

        <div class="container">

            <h1>
                <span>
                   @yield('page-title')
                </span>
            </h1>

        </div>

    </div>

@endsection

@section('body')

    @include('website.navigation.navbar')

    @yield('header')

    @yield('container')

@endsection