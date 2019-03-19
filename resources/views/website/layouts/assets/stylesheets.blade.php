@if(Auth::check() && Auth::user()use_dark_theme)

@endif
<link rel="stylesheet" href="{{ asset('assets/application-light.min.css') }}">