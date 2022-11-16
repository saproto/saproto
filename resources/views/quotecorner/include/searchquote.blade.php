<form method="get" action="{{ route('quotes::search') }}">
    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Search for quotes!
        </div>

        <div class="card-body">
            <div class="form-group">
                Search term:
                <input class="form-control" id="searchTerm" name="searchTerm" placeholder="Ysbrand" value="{{$searchTerm??''}}" required>
            </div>
        </div>

        <div class="card-footer">
            <input type="submit" class="btn btn-success btn-block" value="Search quotes!">
        </div>

    </div>
</form>