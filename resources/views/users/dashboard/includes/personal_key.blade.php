<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Personal key
    </div>

    <div class="card-body">

        <p class="card-text">
            Your personal key is:<br>
            <sup><em>{{ $user->getPersonalKey() }}</em></sup>
        </p>

        <p class="card-text">
            If you don't know what you need this for, you don't need it. <i class="far fa-smile-wink"></i>
        </p>

    </div>

    <div class="card-footer">

        <a href="{{ route('user::personal_key::generate') }}" class="btn btn-outline-danger btn-block"
           onclick="return confirm('Are you sure? This will invalidate any personal links including your personalized calendar.');">
            Mine has been compromised, generate me a new one
        </a>

    </div>

</div>