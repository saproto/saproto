@extends('website.layouts.redesign.generic')

@section('page-title')
    Edit {{ $photos->album_title }} ({{ date('M j, Y', $photos->album_date) }})
@endsection

@section('container')

    @if($photos->published == False)

        @if(Auth::check() && Auth::user()->can('protography'))
            <a class="btn btn-warning text-white btn-block mb-3"
               href="{{ route('photo::admin::publish', ['id'=>$photos->album_id]) }}">
                This album is not yet published
                , click here to publish the album.
            </a>
        @else
            <span class="btn btn-warning text-white btn-block mb-3" style="cursor: default;">
            This album is not yet published
            , ask a Protography admin to publish it.
            </span>
        @endif

    @endif

    @if($photos->event !== null)

        <a class="btn btn-info btn-block mb-3"
           href="{{ route('event::show', ['event_id'=>$photos->event->getPublicId()]) }}">
            This album is linked to the event {{ $photos->event->title }}, click here to go to the event.
        </a>

    @endif

    <div class="row">
        <div class="col-lg-3">
            <div class="card mb-3">

                <div class="card-header bg-dark text-white text-center">
                    Edit album
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="album">Album name:</label>
                        <input type="text" id="album" name="album" class="form-control"
                               value="{{ $photos->album_title }}">
                    </div>
                    <div class="form-group">
                        <label for="date">Album date:</label>
                        @include('website.layouts.macros.datetimepicker', [
                                'name' => 'date',
                                'format' => 'date',
                                'placeholder' => date($photos->album_date)
                            ])
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="private"
                               name="private" {{ $photos->private ? "checked" : "" }}>
                        <label class="form-check-label" for="private">Private album</label>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-success btn-block" value="Save">
                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
                        Delete Album
                    </button>
                </div>

            </div>

            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Album</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            This will delete the album and all the photos inside.<br>
                            Are you sure you want to delete the album?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a class="btn btn-danger" href="{{ route('photo::admin::delete', ['id' => $photos->album_id]) }}">Delete Album</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mb-3">

                <div class="card-header bg-dark text-white text-center">
                    Thumbnail
                </div>

                <div class="card-body" style="height: 300px; background: url({{ $photos->thumb }})">
                </div>

            </div>
        </div>

        <div class="col-lg-9">
            <div class="card mb-3">

                <div class="card-header bg-dark text-white text-center">
                    Add photos
                </div>

                <div class="card-body">

                    <div id="uploadview" class="row" style="min-height: 200px;">
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            Drag photos here
                        </div>

                    </div>

                    <div id="photoadmin__droparea">
                        <div id="photoadmin__droparea__content" class="text-center">
                            <span class="fa fa-images" style="font-size: 10rem;"></span><br>
                            <span>Drop photos to upload</span>
                        </div>
                    </div>

                </div>

                <div class="card-footer text-center">
                    Doe ff upload balkje ofzo hier
                </div>

            </div>


            <div class="card mb-3">
                <form method="POST" action="{{ route('photo::admin::action', ['id' => $photos->album_id]) }}">
                    {{ csrf_field() }}

                    <div class="card-header bg-dark text-white text-center">
                        {{ $photos->album_title }} ({{ date('M j, Y', $photos->album_date) }})
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12" style="margin-bottom:15px;">
                                <div class="btn-group" role="group" aria-label="Toolbar">
                                    <button type="submit" name="submit" value="remove" class="btn btn-danger"><i
                                                class="fa fa-trash"></i> Remove
                                    </button>
                                    <button type="submit" name="submit" value="thumbnail" class="btn btn-success"><i
                                                class="fa fa-image"></i> Set thumbnail
                                    </button>
                                    <button type="submit" name="submit" value="private" class="btn btn-warning"><i
                                                class="fa fa-eye"></i> Toggle private
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="photoview" class="row">

                            @foreach($photos->photos as $key => $photo)

                                <div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">
                                    <div class="photo-select">
                                        <input name="photo[{{ $photo->id }}]" type="checkbox"
                                               style="align-self: flex-start;" id="photo_{{ $photo->id }}">
                                        <div class="card mb-3">
                                            <label for="photo_{{ $photo->id }}" class="card-img photo_pop"
                                                   style="display: flex; height: 200px; background-image: url({{ $photo->thumb() }});">
                                                @if($photo->private)
                                                    <p class="card-text ellipsis" style="align-self: flex-end;">
                                                        <i class="fas fa-eye-slash ml-4 mr-2 text-info"
                                                           data-toggle="tooltip" data-placement="top"
                                                           title="This photo is only visible to members."></i>
                                                    </p>
                                                @endif
                                            </label>

                                        </div>
                                    </div>

                                    {{--                                @include('website.layouts.macros.card-bg-image', [--}}
                                    {{--                                'url' => route("photo::view", ["id"=> $photo->id]),--}}
                                    {{--                                'img' => $photo->thumb(),--}}
                                    {{--                                'html' => sprintf('<i class="fas fa-heart"></i> %s',--}}
                                    {{--                                    $photo->getLikes()),--}}
                                    {{--                                'photo_pop' => true,--}}
                                    {{--                                'height' => 200,--}}
                                    {{--                                'footer' => sprintf('<button class="btn fa fa-image btn-%s></button>--}}
                                    {{--                                                     <button class="btn btn-danger fa fa-trash"></button>',--}}
                                    {{--                                ($photo->id == $photos->thumb) ? 'secondary" disabled' : 'success"')--}}
                                    {{--                                ])--}}

                                </div>

                            @endforeach

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('javascript')

    @parent

    <script>


        //Handle Drag and drop file uploading

        var fileQueue = [];
        var nextId = 1;
        var uploadRunning = false;
        var droparea = document.getElementById('photoadmin__droparea');

        (function () {
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                window.addEventListener('dragover', function (e) {
                    droparea.style.display = 'block';
                    e.stopPropagation();
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'copy';
                }, false);
                droparea.addEventListener('dragleave', function (e) {
                    droparea.style.display = 'none';
                    e.stopPropagation();
                    e.preventDefault();
                }, false);
                window.addEventListener('drop', dropFiles, false);
            }
        }());


        function addFileDropListeners() {

        }


        function dropFiles(e) {
            droparea.style.display = 'none';
            e.stopPropagation();
            e.preventDefault();
            let files = e.dataTransfer.files;
            if (files.length) {
                for (let i = 0; i < files.length; i++) {
                    let file = files[i];
                    if (file.type === 'image/png' || file.type === 'image/jpg' || file.type === 'image/jpeg') {
                        console.log(file.name);
                        let fr = new FileReader();
                        fr.onload = function () {
                            $('#uploadview').append('<div id="file' + nextId + '" class="col-lg-2 col-lg-3 col-md-4 col-sm-6"><img alt="uploadedImage" src="' + fr.result + '"/></div>');
                            file.id = nextId;
                            nextId++;
                            fileQueue.push(file);
                            if (!uploadRunning) {
                                uploadFile();
                            }
                        };
                        fr.readAsDataURL(file);
                    }
                }
            }
        }

        function uploadFile() {
            uploadRunning = true;
            let uploadFile = fileQueue.shift();
            console.log(uploadFile.id);
            var data = new FormData();
            data.append('file', uploadFile);
            data.append('_token', '<?php echo csrf_token() ?>');
            $.ajax({
                type: "POST",
                url: '{{ route('photo::admin::upload', ['id' => $photos->album_id]) }}',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log('Response: ' + uploadFile.id);
                    $('#file' + uploadFile.id).remove();
                    $('#photoview').append('<div class="col-lg-2 col-lg-3 col-md-4 col-sm-6"><img alt="uploadedImage" src="' + response + '"/></div>');
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log('Upload failed')
                }
            });
            if (fileQueue.length > 0) {
                uploadFile();
            } else {
                uploadRunning = false;
            }
        }

        (function (window, location) {
            history.replaceState(null, document.title, location.pathname + "#!/stealingyourhistory");
            history.pushState(null, document.title, location.pathname);

            window.addEventListener("popstate", function () {
                if (location.hash === "#!/stealingyourhistory") {
                    history.replaceState(null, document.title, location.pathname);
                    setTimeout(function () {
                        location.replace("{{ route('photo::admin::index')}}");
                    }, 0);
                }
            }, false);
        }(window, location));
    </script>

@endsection
