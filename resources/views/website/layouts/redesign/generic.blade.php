@extends('website.master')

@section('body')

    @include('website.navigation.navbar')

    <div style="width: 100%; height: 71px;">&nbsp;</div>

    <main role="main" class="container-fluid" style="min-height: 58vh">

        @include('website.announcements')

        @yield('container')

    </main>

    @include('website.footer')

@endsection
