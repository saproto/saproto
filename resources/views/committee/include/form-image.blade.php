<form method="post" action="{{ route("committee::image", ["id" => $committee->id]) }}"
      enctype="multipart/form-data">

    {!! csrf_field() !!}

    <div class="card mb-3">

        @if($committee->image)

            <img class="card-img-top" src="{!! $committee->image->generateImagePath(700,300) !!}" width="100%">

            <div class="card-header bg-dark text-white">
                Replace image
            </div>

        @else

        <div class="card-header bg-dark text-white">
            Set image
        </div>

        @endif

        <div class="card-body">

            <div class="custom-file">
                <input type="file" class="custom-file-input" id="image" name="image">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success btn-block">
                Replace committee image
            </button>
        </div>

    </div>

</form>