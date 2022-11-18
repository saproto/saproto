@if(Carbon::now()->month===Carbon::NOVEMBER && Cookie::get('disable-december')!=='disabled')
    <link rel="stylesheet" href="{{ mix('/css/application-december.css') }}">
    @for($count=0; $count<12*12; $count++)
        <div class="snowflake"></div>
    @endfor
@elseif(Auth::check() && Auth::user()->theme)
    <link rel="stylesheet" href="{{ mix("/css/application-".config('proto.themes')[Auth::user()->theme].".css") }}">
@else
    <link rel="stylesheet" href="{{ mix('/css/application-light.css') }}">
@endif
