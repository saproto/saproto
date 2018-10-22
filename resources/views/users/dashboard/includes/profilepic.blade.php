<form method="post" enctype="multipart/form-data" action="{{ route("user::pic::update") }}">

    {!! csrf_field() !!}

<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Profile photo
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-5 d-flex align-items-center">
                <h5 class="text-center">This is you <i class="far fa-hand-point-right ml-2"></i></h5>
            </div>

            <div class="col-7 text-center">
                <img src="{{ $user->generatePhotoPath(150, 150) }}" width="150px" height="150px" class="rounded-circle">
            </div>

        </div>

    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-9">
                <div class="input-group">
                    <div class="custom-file">
                        <input name="image" type="file" class="custom-file-input">
                        <label class="custom-file-label">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-primary" type="button">
                            <i class="fas fa-file-upload"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <a href="{{ route("user::pic::delete") }}" class="btn btn-outline-danger btn-block">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </div>
    </div>

</div>