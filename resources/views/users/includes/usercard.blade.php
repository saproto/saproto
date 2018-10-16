<div class="card mb-3 leftborder leftborder-info">
    <div class="card-body">
        <img width="50px" height="50px" class="rounded-circle float-right"
             src="{!! $user->generatePhotoPath(50, 50) !!}">
        <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}">
            <strong>{{ $user->name }}</strong><br>
        </a>
        {!! $subtitle !!}
    </div>
</div>