@if(Auth::check() && Auth::user()->theme)
    <link rel="stylesheet" href="{{ asset("assets/application-".config('proto.themes')[Auth::user()->theme].".css") }}">
@else
    <link rel="stylesheet" href="{{ asset('assets/application-light.css') }}">
@endif