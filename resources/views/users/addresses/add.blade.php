@extends('website.layouts.panel')

@section('page-title')
    Add address for {{ $user->name }}
@endsection

@section('panel-title')
    Add an address for {{ $user->name }}
@endsection

@section('panel-body')

    <form class="form-horizontal" method="POST" action="{{ route('user::address::add', ['id' => $user->id]) }}">
        @include('users.addresses.form')
    </form>

@endsection