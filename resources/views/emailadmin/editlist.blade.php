@extends('website.layouts.panel')

@section('page-title')
    E-mail List Administration
@endsection

@section('panel-title')
    {{ ($list == null ? "Create a new list." : "Edit list " . $list->name .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($list == null ? route("email::list::add") : route("email::list::edit", ['id' => $list->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">List name:</label>
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Members will see this name, make it descriptive."
                   value="{{ $list->name or '' }}" required>
        </div>

        <div class="form-group">
            <label for="editor">Description</label>
            @if ($list == null)
                <textarea id="editor" name="description"
                          placeholder="Please tell - concisely - what this list is used for."></textarea>
            @else
                <textarea id="editor" name="description">{{ $list->description }}</textarea>
            @endif
        </div>

        @endsection

        @section('panel-footer')

            <div class="checkbox pull-left">
                <label>
                    <input type="checkbox"
                           name="is_member_only" {{ $list != null && $list->is_member_only ? 'checked="checked"' : '' }}>
                    Only for members
                </label>
            </div>

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("email::admin") }}" class="btn btn-default pull-right">Cancel</a>

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