@if(Auth::check() && Auth::user()->theme)
    <link rel="stylesheet" href="{{ asset(Auth::user()->theme) }}">
@else
    <link rel="stylesheet" href="{{ asset('assets/application-light.min.css') }}">
@endif