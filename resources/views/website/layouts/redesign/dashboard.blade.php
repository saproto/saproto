@extends('website.master')

@section('body')

    @include('website.navigation.navbar')

    <main role="main" id="dashboard" class="container-fluid border-dark">

        @include('website.announcements')

        @yield('container')

    </main>

@endsection