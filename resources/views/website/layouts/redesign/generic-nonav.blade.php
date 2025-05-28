@extends('website.master')

@section('body')
    <main
        role="main"
        class="container-fluid border-top border-4 border-primary pt-3"
    >
        @include('website.announcements')

        @yield('container')
    </main>

    @include('website.footer')
@endsection
