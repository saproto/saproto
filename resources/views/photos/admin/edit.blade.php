@extends('website.layouts.redesign.generic')

@section('page-title')
    Edit {{ $photos->album_title }} ({{ date('M j, Y', $photos->album_date) }})
@endsection

@section('container')

    @if($photos->published == True)
        @if(Auth::check() && Auth::user()->can('publishalbums'))
            <a class="btn btn-warning text-white btn-block mb-3"
               href="{{ route('photo::admin::unpublish', ['id'=>$photos->album_id]) }}">
                This album is published so editing is limited
                , click here to unpublish the album.
            </a>
        @else
            <span class="btn btn-warning text-white btn-block mb-3" style="cursor: default;">
            This album is published so editing is limited
            , ask a Protography admin to unpublish it if you wish to make changed.
            </span>
        @endif
    @else
        @if(Auth::check() && Auth::user()->can('publishalbums'))
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

                @if(Auth::user()->can('publishalbums') || (Auth::user()->can('protography') && !$photos->published))
                    <div class="card-header bg-dark text-white text-center">
                        Edit album
                    </div>

                    <form method="post">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="album">Album name:</label>
                                <input required type="text" id="album" name="album" class="form-control"
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
                            <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                    data-target="#deleteModal">
                                Delete Album
                            </button>
                        </div>

                    </form>
                @else
                    <div class="card-header bg-dark text-white text-center">
                        Edit album
                    </div>

                    <div class="card-body">
                        <b>Album name:</b> {{ $photos->album_title }}<br>
                        <b>Album date:</b> {{ date('d-m-Y', $photos->album_date) }}<br>
                        <b>Private album:</b> <i class="fa fa-{{ $photos->private ? "check" : "times"}}"></i>
                    </div>
                @endif
            </div>

            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
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
                            <a class="btn btn-danger"
                               href="{{ route('photo::admin::delete', ['id' => $photos->album_id]) }}">Delete Album</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mb-3">

                <div class="card-header bg-dark text-white text-center">
                    Thumbnail
                </div>

                <div class="card-body" style="height: 300px; background: url({{ $photos->thumb }}) no-repeat center; background-size: cover;">
                </div>

            </div>
        </div>

        <div class="col-lg-9">
            <div class="card mb-3">

                <div class="card-header bg-dark text-white text-center">
                    Add photos
                </div>
                @if(!$photos->published)
                    <div class="card-body">
                        <div id="errorBar" class="alert alert-danger" style="display: none;" role="alert">
                            <h4 class="alert-heading">Error uploading some files</h4>
                            <p>The following files failed to upload:</p>
                            <ul></ul>
                        </div>
                        <div id="uploadview" class="row position-relative" style="min-height: 200px;">
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
                @else
                    <div class="card-footer text-center">
                        Uploading is disabled for published albums, unpublish the album to upload extra photos.
                    </div>
                @endif
            </div>


            <div class="card mb-3">
                <form method="POST" action="{{ route('photo::admin::action', ['id' => $photos->album_id]) }}">
                    {{ csrf_field() }}

                    <div class="card-header bg-dark text-white text-center">
                        {{ $photos->album_title }} ({{ date('M j, Y', $photos->album_date) }})
                    </div>

                    <div class="card-body">
                        @if(!$photos->published || Auth::user()->can('publishalbums'))
                            <div class="row">
                                <div class="col-12" style="margin-bottom:15px;">
                                    <div class="btn-group" role="group" aria-label="Toolbar">
                                        <button
                                                @if($photos->published)
                                                type="button" data-toggle="modal" data-target="#publishedModal"
                                                @else
                                                type="submit"
                                                @endif
                                                name="submit" value="remove" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i> Remove
                                        </button>
                                        <button
                                                @if($photos->published)
                                                type="button" data-toggle="modal" data-target="#publishedModal"
                                                @else
                                                type="submit"
                                                @endif
                                                name="submit" value="thumbnail" class="btn btn-success"><i
                                                    class="fa fa-image"></i> Set thumbnail
                                        </button>
                                        <button
                                                @if($photos->published)
                                                type="button" data-toggle="modal" data-target="#publishedModal"
                                                @else
                                                type="submit"
                                                @endif
                                                name="submit" value="private" class="btn btn-warning"><i
                                                    class="fa fa-eye"></i> Toggle private
                                        </button>

                                    </div>

                                    <div class="modal fade" id="publishedModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Perform action</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    This album has already been published.<br>
                                                    Are you sure you want perform this action?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <button id="confirmButton" type="submit" name="submit" value=""
                                                            class="btn"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div id="photoview" class="row">

                            @foreach($photos->photos as $key => $photo)

                                @include('website.layouts.macros.selectablephoto', ['photo' => $photo])


                            @endforeach

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@push('javascript')

    <script>
        var fileQueue = [];
        var nextId = 1;
        var uploadRunning = false;
        var droparea = document.getElementById('photoadmin__droparea');

        (function () {
            $('#publishedModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var value = button.attr('value');
                var text = button.html();
                var classes = button.attr('class');
                var modal = $(this);
                var newButton = modal.find('#confirmButton');
                newButton.html(text);
                newButton.attr('value', value);
                newButton.attr('class', classes);
            });

            //Handle Drag and drop file uploading

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
                    $('#file' + uploadFile.id).remove();
                    if (response === "ERROR") {
                        uploadError(uploadFile);
                    } else {
                        $('#photoview').append(response);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    uploadError(uploadFile);
                }
            });
            if (fileQueue.length > 0) {
                uploadFile();
            } else {
                uploadRunning = false;
            }
        }
        function uploadError(file) {
            $('#errorBar').show();
            $('#errorBar ul').append('<li>' + file.name + '</li>');
        }
    </script>

@endpush
