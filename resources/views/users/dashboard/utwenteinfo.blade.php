<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Your UTwente account</strong>
    </div>
    <div class="panel-body">
        <p style="text-align: center;">
            You can link your UTwente account to use it for authentication.
        </p>
        @if ($user->utwente_username)
            <hr>
            <p style="text-align: center;">
                {{ $utwente->cn or 'Unknown UT Account' }}<br>
                {{ $user->utwente_username }}
            </p>
        @endif
    </div>
    <div class="panel-footer">
        <div class="btn-group btn-group-justified" role="group">
            <div class="btn-group" role="group">
                @if ($user->utwente_username)
                    <a type="button" class="btn btn-danger"
                       href="{{ route('user::utwente::delete', ['id' => $user->id]) }}">
                        Unlink your account
                    </a>
                @else
                    <a type="button" class="btn btn-success"
                       href="{{ route('user::utwente::add', ['id' => $user->id]) }}">
                        Link a UT account
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>