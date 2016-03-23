@extends('website.master')

@section('body')

    @include('website.navigation.navbar')

    @if (Auth::check())
        @include('website.home.members')
    @else
        @include('website.home.external')
    @endif

@endsection