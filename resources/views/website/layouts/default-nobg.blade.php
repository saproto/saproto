@extends('website.layouts.content')

@section('container')
    <div id="container" class="container-nobg container">
        @include('website.announcements')

        @yield('content')
    </div>
@endsection
