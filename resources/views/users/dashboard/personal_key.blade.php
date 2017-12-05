<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Personal key</strong>
    </div>
    <div class="panel-body">

        <div class="row">

            <div class="col-md-12">

                <p style="text-align: center;">
                    Your personal key is:
                </p>

                <p style="text-align: center; font-size: 10px;">
                    {{ $user->getPersonalKey() }}
                </p>

            </div>

        </div>

    </div>

    <div class="panel-footer">

        <div class="btn-group btn-group-justified" role="group"
             onclick="return confirm('Are you sure? This will invalidate any personal links including your personalized calendar.');">
            <div class="btn-group" role="group">
                <a href="{{ route('user::personal_key::generate', ['user' => $user->id]) }}"
                   class="btn btn-warning">
                    Generate me a new personal key
                </a>
            </div>
        </div>

    </div>

</div>