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
                           class="btn btn-default pull-right">
                            Cancel
                        </a>
                        &nbsp;
                        <button type="submit" class="btn btn-success">
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

@endsection

@section('javascript')

    @parent

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({selector: '#editor'});
    </script>

@endsection