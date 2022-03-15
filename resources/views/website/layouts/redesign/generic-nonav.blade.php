@extends('website.master')

@section('body')

    <main role="main" class="container-fluid pt-3" style="border-top: 10px solid var(--primary);">

        @include('website.announcements')

        @yield('container')

    </main>

    @include('website.footer')

@endsection
