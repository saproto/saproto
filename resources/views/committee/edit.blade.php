@extends('website.layouts.default-nobg')

@section('page-title')
    Edit: {{ $committee->name }}
@endsection

@section('content')

    <div class="row">

        <form method="post" action="{{ route("committee::edit", ["id" => $committee->id]) }}">

            {!! csrf_field() !!}

            <div class="col-md-8">

                <div class="panel panel-default container-panel">

                    <div class="panel-body">

                    <textarea id="editor" name="description">
                        {!! $committee->description !!}
                    </textarea>

                    </div>

                    <div class="panel-footer clearfix">
                        <a href="{{ route("committee::show", ["id" => $committee->id]) }}"
                           class="btn btn-default">
                            Cancel
                        </a>
                        &nbsp;
                        <button type="submit" class="btn btn-success pull-right">
                            Save
                        </button>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Committee properties
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="name">Committee name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $committee->name }}">
                        </div>
                        <div class="form-group">
                            <label for="slug">Committee e-mail alias</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                   value="{{ $committee->slug }}">
                        </div>
                        <div class="form-group">
                            <label for="public">Committee visibility</label>
                            <select class="form-control" id="public" name="public">
                                <option value="0" {{ ($committee->public ? '' : 'selected') }}>Only visible to board
                                </option>
                                <option value="1" {{ ($committee->public ? 'selected' : '') }}>Visible to everyone
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

        </form>

    </div>

    <div class="row">

        <form method="post" action="{{ route("committee::image", ["id" => $committee->id]) }}" enctype="multipart/form-data">

            {!! csrf_field() !!}

            <div class="col-md-8">

                <div class="panel panel-default container-panel">

                    <div class="panel-body">

                        @if($committee->image)

                            <img src="{{ route('file::get', $committee->image->id) }}" width="100%;">

                        @else
                            <p style="text-align: center;">
                                This committee has no banner image yet. Upload one now!
                            </p>
                        @endif

                        <hr>

                            <div class="form-horizontal">

                                <div class="form-group">
                                    <label for="image" class="col-sm-4 control-label">New banner image</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="image" type="file" name="image">
                                    </div>
                                </div>

                            </div>

                    </div>

                    <div class="panel-footer clearfix">
                        <button type="submit" class="btn btn-success pull-right">
                            Replace committee image
                        </button>
                    </div>

                </div>

            </div>

        </form>

    </div>

@endsection

@section('javascript')

    @parent

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({selector: '#editor'});
    </script>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        @if($committee->image)
        #header {
            background-image: url('{{ route("file::get", ['id' => $committee->image->id]) }}');
        }
        @endif

    </style>

@endsection