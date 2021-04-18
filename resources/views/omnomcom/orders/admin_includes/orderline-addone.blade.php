<a class="btn btn-success btn-block mb-3" data-toggle="modal" data-target="#orderlinemodal" href="javascript:void();">
    Add orderline wizard. <span class="ml-3">🧙</span>
</a>

<form method="post" action="{{ route('omnomcom::orders::add') }}">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Add an order
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="date">User(s):</label>
                <select class="form-control user-search" id="user" name="user[]" multiple required></select>
            </div>
            <div class="form-group">
                <label for="date">Product(s):</label>
                <select class="form-control product-search" id="product" name="product[]" multiple required></select>
            </div>
        </div>

        <div class="card-footer">
            <input type="submit" class="btn btn-success btn-block" value="Save">
        </div>

    </div>

    <script>
        $('.form-control').select2({width: 'resolve'});
    </script>


</form>