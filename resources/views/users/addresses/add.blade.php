@extends('website.layouts.default-nobg')

@section('page-title')
    Add address for {{ $user->name }}
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Add address for {{ $user->name }}</div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('user::address::add', ['id' => $user->id]) }}">
                @include('users.addresses.form')
            </form>
        </div>
    </div>

@endsection