@extends('website.layouts.panel')

@section('page-title')
    Page Admin
@endsection

@section('panel-title')
    @if($new) Create new page @else Edit page {{ $item->title }} @endif
@endsection

@section('panel-body')

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
                <input type="text" class="form-control datetime-picker" id="slug" name="slug" placeholder="about-proto"
                   value="{{ $item->slug or '' }}" required>
            </div>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="is_member_only" @if(isset($item->is_member_only) && $item->is_member_only) checked @endif>
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

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("page::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection

@section('javascript')

    @parent

    <script>
        var simplemde = new SimpleMDE({
            element: $("#editor")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });
    </script>

@endsection