@extends('website.master')

@section('body')

    @include('website.navigation.navbar')

    <div class="w-100" style="height: 71px;">&nbsp;</div>

    <main role="main" class="container-fluid">

        @include('website.announcements')

        @yield('container')

    </main>

    @include('website.footer')

@endsection
