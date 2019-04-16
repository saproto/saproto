@extends('website.layouts.redesign.generic')

@section('page-title')
    Create Album
@endsection

@section('container')

    <div class="row">
        <div class="col-lg-3">
            <div class="card mb-3">

                <div class="card-header bg-dark text-white text-center">
                    Album info
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="album">Album name:</label>
                        <input type="text" id="album" name="album" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date">Album date:</label>
                        @include('website.layouts.macros.datetimepicker', [
                                'name' => 'date',
                                'format' => 'date',
                                'placeholder' => strtotime(Carbon::now())
                            ])
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="private" name="private">
                        <label class="form-check-label" for="private">Private album</label>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-success btn-block" value="Save">
                </div>

            </div>
        </div>

        <div class="col-lg-9">
            <div class="card mb-3">

                <div class="card-header bg-dark text-white text-center">
                    New Album
                </div>

                <div class="card-body">

                    <div id="photoview" class="row" style="min-height: 200px;">
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            Drag photos here
                        </div>

                    </div>

                </div>

                <div class="card-footer text-center">
                    Doe ff upload balkje ofzo hier
                </div>

            </div>
        </div>
    </div>

    <div id="droparea" style="display: none; z-index: 99999; position: fixed; width: 100vw; height: 100vh; top:0; left: 0; opacity: 0.5; background: antiquewhite;">Drop files to upload</div>

@endsection

@section('javascript')

    @parent

    <script>

        var fileQueue = [];
        var nextId = 0;
        var uploadRunning = false;
        var droparea = document.getElementById('droparea');

        (function() {
            if(window.File && window.FileReader && window.FileList && window.Blob) {
                window.addEventListener('dragover', function(e) {
                    droparea.style.display = 'block';
                    e.stopPropagation();
                    e.preventDefault();
                }, false);
                document.getElementById('droparea').addEventListener('dragleave', function(e) {
                    droparea.style.display = 'none';
                    e.stopPropagation();
                    e.preventDefault();
                }, false);
                window.addEventListener('drop', dropFiles, false);
            }
        }());


        function dropFiles(e) {
            droparea.style.display = 'none';
            e.stopPropagation();
            e.preventDefault();
            let files = e.dataTransfer.files;
            if (files.length) {
                for(let i = 0; i < files.length; i++) {
                    let file = files[i];
                    if (file.type === 'image/png' || file.type === 'image/jpg' || file.type === 'image/jpeg') {
                        console.log(file.name);
                        let fr = new FileReader();
                        fr.onload = function () {
                            $('#photoview').append('<div id="file'+nextId+'" class="col-lg-2 col-lg-3 col-md-4 col-sm-6"><img alt="uploadedImage" src="' + fr.result + '"/></div>');
                        };
                        fr.readAsDataURL(file);
                        file.id = nextId;
                        nextId++;
                        fileQueue.push(file);
                        if(!uploadRunning) {
                            uploadFile();
                        }
                    }
                }
            }
        }

        function uploadFile() {
            let file = fileQueue.shift();
            var data = new FormData();
            data.append('file', file);
            data.append('_token', '<?php echo csrf_token() ?>');
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#file'+file.id).remove();
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    console.log('Upload failed')
                }
            });
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
