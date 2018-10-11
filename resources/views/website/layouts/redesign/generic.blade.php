@extends('website.master')

@section('body')

    @include('website.navigation.navbar')

    <div style="width: 100%; height: 71px;">&nbsp;</div>

    @yield('container')

@endsection
