@extends('website.default.container')

@section('container')

    <h1>{{ $user->name }}</h1>
    <p>{{ $user->email }}</p>

@endsection