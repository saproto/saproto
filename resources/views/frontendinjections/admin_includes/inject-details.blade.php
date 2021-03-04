<form method="post"
      action="{{ ( !isset($injectCurrent) ? route("inject::add") : route("inject::edit", ['id' => $injectCurrent->id])) }}"
      enctype="multipart/form-data">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Front-end Inject
        </div>

        <div class="card-body">

            <label for="name">Inject description:</label>
            <input type="text" class="form-control mb-2" id="name" name="name"
                   placeholder="Description"
                   value="{{ $injectCurrent->name ?? '' }}"
                   required
            />

            <label for="editor">Content</label>
            @include('website.layouts.macros.markdownfield', [
                            'name' => 'content',
                            'placeholder' => "Write your injection here.",
                            'value' => $injectCurrent->content ?? ''
                        ])


            <label class="form-check-label" for="enabled">Enabled</label>
            <input name="enabled"
                   type="checkbox"
                   class="form-check-input ml-2"
                   id="enabled"
                   {{ (isset($injectCurrent->enabled) && $injectCurrent->enabled == 1 ? 'checked' : '') }}
            />

        </div>
        <div class="card-footer border-bottom">
            <button type="submit" class="btn btn-success">Submit</button>

            @if($injectCurrent)
                <a href="{{ route('inject::delete', ['id' => $injectCurrent->id]) }}"
                   class="btn btn-danger ml-4">Delete</a>
            @endif
        </div>

    </div>

</form>