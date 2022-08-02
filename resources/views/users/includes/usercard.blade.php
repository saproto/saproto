<div class="card mb-3 leftborder leftborder-info">
    <div class="card-body">
        @if($user->is_member)
            <img width="50px" height="50px" class="rounded-circle float-end"
                 src="{!! $user->generateTinyPhotoPath() !!}">
            <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}">
                <strong>{{ $user->name }}</strong><br>
            </a>
        @else
            <span class="text-muted">{{ $user->name }}</span><br>
        @endif
        <div class="ellipsis">
            {!! $subtitle !!}
        </div>
    </div>
    @if(isset($footer) && $footer)
        <div class="card-footer">
            {!! $footer !!}
        </div>
    @endif
</div>