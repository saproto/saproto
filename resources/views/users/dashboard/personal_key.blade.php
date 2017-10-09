<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Personal key</strong>
    </div>
    <div class="panel-body">

        <div class="row">

            <div class="col-md-12">

                @if($user->personal_key)

                    <p style="text-align: center;">
                        Your personal key is:
                    </p>

                    <p style="text-align: center; font-size: 10px;">
                        {{ $user->personal_key }}
                    </p>

                @else

                    <p>
                        A personal key is used for some functionality mainly aimed at developers. If you don't know what
                        you need it for, you probably don't need it.
                    </p>

                @endif

            </div>

        </div>

    </div>

    <div class="panel-footer">

        <div class="btn-group btn-group-justified" role="group"
             onclick="confirm('Are you sure? Any previous key will not work anymore.'   );">
            <div class="btn-group" role="group">
                <a href="{{ route('user::personal_key::generate', ['user' => $user->id]) }}"
                   class="btn btn-warning">
                    Generate me a new personal key
                </a>
            </div>
        </div>

    </div>

</div>