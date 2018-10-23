@extends('website.master')

@section('body')

    @include('website.navigation.navbar')

    <div style="width: 100%; height: 71px;">&nbsp;</div>

    <main role="main" class="container-fluid">

        @include('website.announcements')

        @yield('container')

    </main>

    <footer class="main-footer bg-dark" style="position: absolute; bottom: 0; width: 100%; height: 20px;">
    </footer>

@endsection

@section('body-style')
    margin-bottom: 20px !important;
@endsection