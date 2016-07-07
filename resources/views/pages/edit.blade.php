@extends('website.layouts.default-nobg')

@section('page-title')
    @if($new) Create new page @else Edit page {{ $item->title }} @endif
@endsection

@section('content')

    <div class="row">

        <div class="{{ ($new ? 'col-md-6 col-md-offset-3' : 'col-md-7') }}">

            <div class="panel panel-default">

                <div class="panel-heading">

                    Page content

                </div>

                <div class="panel-body">

                    <form method="post"
                          action="@if($new) {{ route("page::add") }} @else {{ route("page::edit", ['id' => $item->id]) }} @endif"
                          enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="About Proto" value="{{ $item->title or '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="slug">URL:</label>
                            <div class="input-group">
                                <div class="input-group-addon">{{ route('page::show', '') }}/</div>
                                <input type="text" class="form-control datetime-picker" id="slug" name="slug"
                                       placeholder="about-proto"
                                       value="{{ $item->slug or '' }}" required>
                            </div>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="is_member_only"
                                       @if(isset($item->is_member_only) && $item->is_member_only) checked @endif>
                                <i class="fa fa-lock" aria-hidden="true"></i> Members only
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="editor">Content</label>
                            @if ($item == null)
                                <textarea id="editor" name="content"
                                          placeholder="Enter page content here..."></textarea>
                            @else
                                <textarea id="editor" name="content">{{ $item->content }}</textarea>
                            @endif
                        </div>


                        <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit
                        </button>

                        <a href="{{ route("page::list") }}" class="btn btn-default pull-right">Cancel</a>

                    </form>
                </div>
            </div>


            @if(!$new)

                <form method="post" action="{{ route("page::image", ["id" => $item->id]) }}"
                      enctype="multipart/form-data">

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            Update featured image
                        </div>

                        <div class="panel-body">

                            {!! csrf_field() !!}

                            @if($item->featuredImage)

                                <img src="{!! $item->featuredImage->generateImagePath(700,null) !!}" width="100%;">

                            @else
                                <p>
                                    &nbsp;
                                </p>
                                <p style="text-align: center;">
                                    This page has no featured image yet. Upload one now!
                                </p>
                            @endif

                            <hr>

                            <div class="form-horizontal">

                                <div class="form-group">
                                    <label for="image" class="col-sm-4 control-label">New featured image</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="image" type="file" name="image" accept="image/*">
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="panel-footer clearfix">
                            <button type="submit" class="btn btn-success pull-right">
                                Replace featured image
                            </button>
                        </div>

                    </div>
                </form>

            @endif

        </div>

        @if(!$new)

            <div class="col-md-5">

                <div class="panel panel-default">

                    <div class="panel-heading">

                        Attached files

                    </div>

                    <div class="panel-body">

                        @if ($item->files->count() > 0)

                            <table class="table">

                                <thead>

                                <tr>

                                    <th>Filename</th>
                                    <th>Controls</th>

                                </tr>

                                </thead>

                                @foreach($item->files as $file)

                                    <tr>

                                        <td><a href="{{ $file->generatePath() }}" target="_blank">{{ $file->original_filename }}</a></td>
                                        <td>
                                            @if(substr($file->mime, 0, 5) == 'image')
                                                <a class="btn btn-xs btn-default pageEdit_insertImage"
                                               href="#" role="button" rel="{{ $file->generateImagePath(1000, null) }}">
                                                    <i class="fa fa-image" aria-hidden="true"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-xs btn-default pageEdit_insertLink"
                                                   href="#" role="button" rel="{{ $file->generatePath() }}">
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                            <a class="btn btn-xs btn-danger"
                                               href="{{ route('page::file::delete', ['id' => $item->id, 'file_id' => $file->id]) }}" role="button">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                    </tr>

                                @endforeach

                            </table>

                        @else

                            <p style="text-align: center;">
                                There are currently no files attached to this page.
                            </p>

                        @endif

                            <hr>

                            <form method="post" action="{{ route("page::file::add", ["id" => $item->id]) }}" enctype="multipart/form-data">

                                {!! csrf_field() !!}

                                <div class="form-horizontal">

                                    <div class="form-group">
                                        <label for="image" class="col-sm-4 control-label">New file</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" id="file" type="file" name="file">
                                        </div>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-success pull-right">
                                    Upload file
                                </button>

                            </form>

                    </div>


            </div>

        @endif

    </div>

        <style type="text/css">
            .CodeMirror img {
                width: 100%;
            }
        </style>



@endsection

@section('javascript')

    @parent

    <script>
        var simplemde = new SimpleMDE({
            element: $("#editor")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "image", "link", "quote", "table", "code", "|", "preview", "guide"],
            spellChecker: false
        });


        // Borrowed from http://stackoverflow.com/questions/23733455/inserting-a-new-text-at-given-cursor-position
        function insertLineAtCursor(data){
            var cm = $('.CodeMirror')[0].CodeMirror;
            var doc = cm.getDoc();
            var cursor = doc.getCursor(); // gets the line number in the cursor position
            var line = doc.getLine(cursor.line); // get the line contents
            var pos = { // create a new object to avoid mutation of the original selection
                line: cursor.line,
                ch: line.length - 1 // set the character position to the end of the line
            };
            doc.replaceRange('\n'+data+'\n', pos); // adds a new line
        }

        $(".pageEdit_insertLink").click(function(e) {
            e.preventDefault();
            var linkUrl = $(this).attr('rel');
            insertLineAtCursor("[Link text](" + linkUrl + ")");
        });

        $(".pageEdit_insertImage").click(function(e) {
            e.preventDefault();
            var linkUrl = $(this).attr('rel');
            insertLineAtCursor("![Alt text](" + linkUrl + ")");
        });
    </script>

@endsection