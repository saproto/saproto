@if(Auth::check() && Auth::user()->isElegibleForKickInCamp())
    <a href="{{ route('event::show', ['id'=>config('proto.kickinEvent')->event]) }}">
        <div class="alert alert-success" role="alert" style="text-align: center;">
            <strong>Hey {{ Auth::user()->calling_name }}!</strong>
            It looks like you're new at our study. Why not check out our introduction camp? Click here!<br>
            <sup>(This message will self-destruct on {{ date('F j', config('proto.kickinEvent')->end) }}.)</sup>
        </div>
    </a>

@endif