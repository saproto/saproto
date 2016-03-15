@extends('website.layouts.panel')

@section('panel-title')
    @yield('errornumber'): @yield('errorshort')
@endsection

@section('panel-body')
    @yield('errormessage')
@endsection