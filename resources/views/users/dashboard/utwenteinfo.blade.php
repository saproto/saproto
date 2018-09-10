<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Your university account</strong>
    </div>
    <div class="panel-body">
        @if ($user->utwente_username)
            <p style="text-align: center;">
                {{ $user->utwente_username }} ({{ $user->utwente_department }})
            </p>
        @elseif($user->edu_username)
            <p style="text-align: center;">{{$user->edu_username}}</p>
        @else
            <p style="text-align: center;">
                You can link a university account to your Proto account for easier log-in.
            </p>
            <p style="text-align: center;">
                Linking a UTwente account also unlocks more functionality on the site.
            </p>
        @endif
    </div>
    <div class="panel-footer">
        <div class="btn-group btn-group-justified" role="group">
            <div class="btn-group" role="group">
                @if ($user->edu_username)
                    <a type="button" class="btn btn-danger"
                       href="{{ route('user::edu::delete') }}">
                        Unlink your account
                    </a>
                @else
                    <a type="button" class="btn btn-success"
                       href="{{ route('user::edu::add') }}">
                        Link a university account
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>