@extends('website.layouts.default-nobg')

@section('page-title')
    Edit address for {{ $user->name }}
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Edit an address for {{ $user->name }}</div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST"
                  action="{{ route('user::address::edit', ['id' => $user->id]) }}">
                @include('users.addresses.form')
            </form>
        </div>
    </div>

@endsection

@section('javascript')

    @parent

    @include('users.addresses.js')

@endsection