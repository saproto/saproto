@extends('website.default.panel')

@section('page-title')
    Edit address for {{ $user->name }}
@endsection

@section('panel-title')
    Edit an address for {{ $user->name }}
@endsection

@section('panel-body')

    <p></p><strong>Current address:</strong></p>
    <p>
        {{ $address->street }} {{ $address->number }}<br>
        {{ $address->zipcode }}, {{ $address->city }}<br>
        {{ $address->country }}
    </p>

    <hr>

    <form class="form-horizontal" method="POST" action="{{ route('user::address::edit', ['id' => $user->id, 'address_id' => $address->id]) }}">
        @include('users.addresses.form')
    </form>

@endsection