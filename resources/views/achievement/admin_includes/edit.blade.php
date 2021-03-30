<form method="post"
      action="{{ ($new ? route("achievement::add") : route("achievement::update", ['id' => $achievement->id])) }}">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            @yield('page-title')
            @if(!$new)
                <span class="badge badge-info float-right">
                    Obtained by {{ count($achievement->currentOwners(true)) }} members
                </span>
            @endif
        </div>

        <div class="card-body">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Be Awesome"
                       value="{{ $achievement->name or '' }}" required>
            </div>

            <div class="form-group">
                <label for="desc">Description:</label>
                <input type="text" class="form-control" id="desc" name="desc"
                       placeholder="Become member of Proto"
                       value="{{ $achievement->desc or '' }}" required>
            </div>

            <div class="form-group">
                <label for="tier">Tier:</label>
                <select class="form-control {{ $achievement->tier or '' }}" name="tier">
                    <option value="COMMON"
                            {{ (!$new && $achievement->tier == "COMMON" ? 'selected' : '') }}>
                        Common
                    </option>
                    <option value="UNCOMMON"
                            {{ (!$new && $achievement->tier == "UNCOMMON" ? 'selected' : '') }}>
                        Uncommon
                    </option>
                    <option value="RARE"
                            {{ (!$new && $achievement->tier == "RARE" ? 'selected' : '') }}>Rare
                    </option>
                    <option value="EPIC"
                            {{ (!$new && $achievement->tier == "EPIC" ? 'selected' : '') }}>Epic
                    </option>
                    <option value="LEGENDARY"
                            {{ (!$new && $achievement->tier == "LEGENDARY" ? 'selected' : '') }}>
                        Legendary
                    </option>
                </select>
            </div>

            <div class="form-group">
                <input type="checkbox" id="is_archived" name="is_archived"
                       {{ (!$new && $achievement->is_archived ? 'checked' : '') }}>
                <label for="is_archived">Archive this achievement</label>
            </div>

            <div class="form-group">
                <input type="checkbox" id="has_page" name="has_page"
                       {{ ($achievement->has_page ? 'checked' : '') }}>
                <label for="has_url">Can be achieved by visiting url</label>
            </div>

            <div id="achieve_page_block" @if(!$achievement->has_page) style="display: none;" @endif>

                <div class="form-group">
                    <label for="page_name">Achieve URL</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">saproto.nl/achieve/</span>
                        </div>
                        <input type="text"
                               class="form-control"
                               id="page_name"
                               name="page_name"
                               value="{{ $achievement->page_name ?? str_replace(' ', '-', strtolower($achievement->name)) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    @include('website.layouts.macros.markdownfield', [
                        'name' => 'page_content',
                        'placeholder' => 'Achievement page message.',
                        'value' => $achievement->page_content ?? null
                    ])
                </div>

            </div>



        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-success float-right">Submit</button>

            <a href="{{ route("achievement::list") }}" class="btn btn-default">Cancel</a>

        </div>

    </div>

</form>

@section('javascript')
    @parent
    <script type="text/javascript">
        let pageBlock = $('#achieve_page_block');
        $('#has_page').on('click', function() {
            if($(this).is(':checked')) {
                pageBlock.show();
                pageBlock.find('input').attr('required', true);
            } else {
                pageBlock.hide();
                pageBlock.find('input').attr('required', false);
            }
        });
    </script>
@endsection