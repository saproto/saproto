<form method="post" action="{{ route('omnomcom::orders::add') }}">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Add a(n) order(s)
        </div>

        <div class="card-body">
            <div class="form-group autocomplete">
                <label for="user">User(s):</label>
                <input class="form-control user-search" id="user" name="user[]" data-label="User(s):" multiple required>
            </div>
            <div class="form-group autocomplete">
                <label for="product">Product(s):</label>
                <input class="form-control product-search" id="product" name="product[]" multiple required>
            </div>
            <div class="form-group">
                <label for="description">Description (optional)</label>
                <input class="form-control" id="description" name="description">
            </div>
        </div>

        <div class="card-footer">
            <input type="submit" class="btn btn-success btn-block" value="Save">
        </div>

    </div>


</form>