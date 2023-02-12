@if(Auth::check() && Auth::user()->is_member)
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            Custom OmNomCom Sound
        </div>
        @if(Auth::user()->member->customOmnomcomSound)
            <div class="card-body">
                <div class="d-inline-flex justify-content-around w-100">
              Your custom sound:
                    <audio controls>
                        <source src="{{ Auth::user()->member->customOmnomcomSound->generatePath() }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>

            </div>
        @else
            <div class="text-center">
                You do not have set a custom omnomcom sound yet! Upload one below.<br>
                <i>Note: it can not be larger than 200kb and it can be no longer than 5 seconds!</i>
            </div>
        @endif

        <form method="post" action="{{ route('user::omnomcomsound::update') }}" enctype="multipart/form-data">

            {!! csrf_field() !!}

                <div class="card-footer">
                    <div class="row">
                        <div class="col-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input id="sound" type="file" class="form-control" name="sound">
                                </div>
                                <button type="submit" class="btn btn-outline-info">
                                    <i class="fas fa-file-upload"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-3">
                            <a href="{{ route("user::omnomcomsound::delete", ['id'=>Auth::user()->id]) }}" class="btn btn-outline-danger btn-block">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endif