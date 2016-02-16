@extends('website.default.container')

@section('container')

    <div class="col-md-6 col-md-offset-3 col-xs-12 col-xs-offset-0">

        <div class="panel panel-default">
            <div class="panel-heading">New address for {{ $user->name }}</div>
            <div class="panel-body">
                <form method="POST" action="{{ route('user::address::add', ['id' => $user->id]) }}">
                    @include('users.addresses.form')
                </form>
            </div>
        </div>

    </div>

@endsection