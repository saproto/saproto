@if(Auth::check() && Auth::user()->theme)
    @vite("resources/assets/sass/".config('proto.themes')[Auth::user()->theme].".scss")
@else
    @vite('resources/assets/sass/light.scss')
@endif