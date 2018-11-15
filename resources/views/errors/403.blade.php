@extends('errors.default')

@section('page-body')

    <p>
        Access denied. <a href="{{ route('login::show') }}">Try logging in.</a>
    </p>

@endsection