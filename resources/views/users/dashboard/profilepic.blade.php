<form method="post" enctype="multipart/form-data" action="{{ route("user::pic::update") }}"
      ng-app="app" ng-controller="Ctrl">

    {!! csrf_field() !!}

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Your profile photo</strong></div>
        <div class="panel-body">

            <div class="profile__photo-wrapper">
                <img class="profile__photo" src="{{ $user->generatePhotoPath(200, 200) }}" alt="">
            </div>

            <hr>

            <p>Update your profile picture: <input type="file" name="image" required/></p>

        </div>

        <div class="panel-footer">

            <div class="row">

                <div class="col-md-6">

                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-success">
                                Update
                            </button>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <a href="{{ route("user::pic::delete") }}" class="btn btn-danger">
                                Delete
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</form>
