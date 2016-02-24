@extends('website.default.panel')

@section('page-title')
    Add address for {{ $user->name }}
@endsection

@section('panel-title')
    Add an address for {{ $user->name }}
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('user::address::add', ['id' => $user->id]) }}">
        @include('users.addresses.form')
    </form>

@endsection