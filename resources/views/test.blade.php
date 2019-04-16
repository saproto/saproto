@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $title }}
@endsection

@section('container')

    {{ $text }}
    <br>
    {{ route('photo::admin::add') }}

@endsection
