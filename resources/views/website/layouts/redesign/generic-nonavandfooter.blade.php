@extends('website.master')

@section('body')

    <main role="main" class="container-fluid pt-3" style="border-top: 10px solid var(--primary);">

        @include('website.announcements')

        @yield('container')

    </main>

    <footer class="main-footer bg-dark" style="position: absolute; bottom: 0; width: 100%; height: 20px;">
    </footer>

@endsection

@section('body-style')
    margin-bottom: 20px !important;
@endsection