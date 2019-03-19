@if(Auth::check() && $user->use_dark_theme)
    <link rel="stylesheet" href="{{ asset('assets/application-dark.min.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('assets/application-light.min.css') }}">
@endif