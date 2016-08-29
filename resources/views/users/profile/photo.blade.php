@if($user->photo)
    <div class="panel panel-default">
        <div class="panel-body" style="background-color: #333; border-left: 5px solid #c1ff00">
            <div class="profile__photo-wrapper">
                <img class="profile__photo" src="{{ $user->photo->generateImagePath(200, 200) }}" alt="">
            </div>
        </div>
    </div>
@endif