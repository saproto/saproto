<div class="card mb-3">

    <div class="card-header">
        Password
    </div>

    <div class="card-body">

        <a href="{{ route('login::password::change') }}" class="btn btn-outline-success btn-block">
            Change Proto password
        </a>

        <a href="https://tap.utwente.nl/chpw1.php" target="_blank" class="btn btn-outline-secondary btn-block">
            Change UTwente password
        </a>

        <hr>

        <p class="card-text">
            This may resolve issues you have logging in to external Proto services such as e-mail, network drives or the
            wiki.
        </p>

        <a href="{{ route('login::password::sync') }}" class="btn btn-outline-success btn-block">
            Synchronize passwords
        </a>

    </div>

</div>