@extends('website.layouts.redesign.dashboard')

@section('page-title')
    @if($new) Create new page @else Edit page {{ $item->title }} @endif
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <form method="post"
                  action="@if($new) {{ route("page::add") }} @else {{ route("page::edit", ['id' => $item->id]) }} @endif"
                  enctype="multipart/form-data">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="About Proto" value="{{ $item->title ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="slug">URL:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ route('page::show', '') }}/</span>
                                </div>
                                <input type="text" class="form-control" name="slug" placeholder="about-proto" value="{{ $item->slug ?? '' }}" required>
                            </div>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="is_member_only"
                                       @if(isset($item->is_member_only) && $item->is_member_only) checked @endif>
                                <i class="fas fa-lock"></i> Members only
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="show_attachments"
                                       @if(isset($item->show_attachments) && $item->show_attachments) checked @endif>
                                Show attachments next to page
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            @include('website.layouts.macros.markdownfield', [
                                'name' => 'content',
                                'placeholder' => 'Text goes here.',
                                'value' => $item ? $item->content : null
                            ])
                        </div>

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-right">
                            Submit
                        </button>

                        <a href="{{ route("page::list") }}" class="btn btn-default">Cancel</a>

                    </div>

                </div>

            </form>

        </div>

        @if(!$new)

            <div class="col-md-3">

                <form method="post" action="{{ route("page::image", ["id" => $item->id]) }}"
                      enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="card mb-3">

                        @if($item->featuredImage)

                            <img src="{!! $item->featuredImage->generateImagePath(700,null) !!}" width="100%;"
                                 class="card-img-top">

                        @endif

                        <div class="card-header bg-dark text-white">
                            Featured image
                        </div>

                        <div class="card-body">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image">
                                <label class="custom-file-label" for="customFile">Upload featured image</label>
                            </div>

                        </div>

                        <div class="card-footer">

                            <button type="submit" class="btn btn-success pull-right btn-block">
                                Replace featured image
                            </button>

                        </div>

                    </div>

                </form>

                <form method="post" action="{{ route("page::file::add", ["id" => $item->id]) }}"
                      enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="card mb-3">

                        <div class="card-header bg-dark text-white mb-1">
                            Attachments
                        </div>

                        @if ($item->files->count() > 0)

                            <table class="table table-hover table-sm">

                                <thead>

                                <tr class="bg-dark text-white">

                                    <td>Filename</td>
                                    <td>Controls</td>

                                </tr>

                                </thead>

                                @foreach($item->files as $file)

                                    <tr>

                                        <td class="pl-3 ellipsis">
                                            <a href="{{ $file->generatePath() }}" target="_blank">
                                                {{ $file->original_filename }}
                                            </a>
                                        </td>
                                        <td>
                                            @if(substr($file->mime, 0, 5) == 'image')
                                                <a class="pageEdit_insertImage" href="#"
                                                   rel="{{ $file->generateImagePath(1000, null) }}">
                                                    <i class="fas fa-image mr-2 fa-fw"></i>
                                                </a>
                                            @else
                                                <a class="pageEdit_insertLink" href="#" role="button"
                                                   rel="{{ $file->generatePath() }}">
                                                    <i class="fas fa-link mr-2 fa-fw"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('page::file::delete', ['id' => $item->id, 'file_id' => $file->id]) }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                        </td>

                                    </tr>

                                @endforeach

                            </table>

                        @endif

                        <div class="card-body">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="files[]" multiple>
                                <label class="custom-file-label" for="customFile">Upload a file</label>
                            </div>

                        </div>

                        <div class="card-footer">

                            <button type="submit" class="btn btn-success btn-block">
                                Upload file
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        @endif

    </div>



@endsection

@push('javascript')

    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        // Borrowed from http://stackoverflow.com/questions/23733455/inserting-a-new-text-at-given-cursor-position
        function insertLineAtCursor(data) {
            let cm = $('.CodeMirror')[0].CodeMirror;
            let doc = cm.getDoc();
            let cursor = doc.getCursor(); // gets the line number in the cursor position
            let line = doc.getLine(cursor.line); // get the line contents
            let pos = { // create a new object to avoid mutation of the original selection
                line: cursor.line, ch: line.length - 1 // set the character position to the end of the line
            };
            doc.replaceRange('\n' + data + '\n', pos); // adds a new line
        }

        $(".pageEdit_insertLink").click(function (e) {
            e.preventDefault();
            let linkUrl = $(this).attr('rel');
            insertLineAtCursor("[Link text](" + linkUrl + ")");
        });

        $(".pageEdit_insertImage").click(function (e) {
            e.preventDefault();
            let linkUrl = $(this).attr('rel');
            insertLineAtCursor("![Alt text](" + linkUrl + ")");
        });
    </script>

@endpush