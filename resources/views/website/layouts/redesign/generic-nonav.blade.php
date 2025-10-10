@extends('website.master')

@section('body')
    <main
        role="main"
        class="container-fluid border-top border-primary border-4 pt-3"
    >
        @include('website.announcements')

        @yield('container')
    </main>

    @include('website.footer')
@endsection
