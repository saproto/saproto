@extends('website.layouts.default-nobg')

@section('page-title')
    @if($new) Create new news article @else Edit news article {{ $item->title }} @endif
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">

                    News content

                </div>

                <div class="panel-body">

                    <form method="post"
                          action="@if($new) {{ route("news::add") }} @else {{ route("news::edit", ['id' => $item->id]) }} @endif"
                          enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Revolutionary new activity!" value="{{ $item->title or '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="event_start">Publish at:</label>
                            <input type="text" class="form-control datetime-picker" id="published_at"
                                   name="published_at"
                                   value="{{ ($item ? date('d-m-Y H:i', strtotime($item->published_at)) : '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="editor">Content</label>
                            @if ($item == null)
                                <textarea id="editor" name="content"
                                          placeholder="Write your insanely great news article here..."></textarea>
                            @else
                                <textarea id="editor" name="content">{{ $item->content }}</textarea>
                            @endif
                        </div>


                        <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">
                            Submit
                        </button>

                        <a href="{{ route("news::list") }}" class="btn btn-default pull-right">Cancel</a>

                    </form>
                </div>
            </div>


            @if(!$new)
            <form method="post" action="{{ route("news::image", ["id" => $item->id]) }}"
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
                line: cursor.line,                ch: line.length - 1 // set the character position to the end of the line
            };
            doc.replaceRange('\n'+data+'\n', pos); // adds a new line
        }

        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fas fa-clock-o",
                date: "fas fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down",
                next: "fas fa-chevron-right",
                previous: "fas fa-chevron-left"
            },
            format: 'DD-MM-YYYY HH:mm'
        });
    </script>

@endsection