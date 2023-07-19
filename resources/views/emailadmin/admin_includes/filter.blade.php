<form method="get" action="{{ route('email::filter') }}">
    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Search emails
        </div>

        <div class="card-body row">
            <div class="form-group col-7">
                <label for="searchterm">Searchterm:</label>
                <input class="form-control" id="searchterm" name="searchterm" required>
            </div>

            <div class="col">
                @include('components.forms.checkbox',[
                                    'name' => 'search_description',
                                    'label' => 'Search description',
                                    'checked' => true,
                                ])
                @include('components.forms.checkbox',[
                                    'name' => 'search_subject',
                                    'label' => 'Search subject'
                                ])
                @include('components.forms.checkbox',[
                                    'name' => 'search_body',
                                    'label' => 'Search body'
                                ])
            </div>
        </div>

        <div class="card-footer">
            <input type="submit" class="btn btn-success btn-block" value="Search emails">
        </div>

    </div>
</form>