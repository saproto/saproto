<form method="get" action="{{ route('omnomcom::orders::adminlist') }}">
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">Filter orderlines</div>

        <div class="card-body">
            <div class="form-group autocomplete">
                @include(
                    'components.forms.datetimepicker',
                    [
                        'not_required' => true,
                        'name' => 'date',
                        'format' => 'date',
                        'placeholder' => $date?->timestamp,
                    ]
                )

                <label for="user">User:</label>
                <input
                    class="form-control user-search"
                    id="user"
                    name="user"
                    data-label="User:"
                />
            </div>

            <div class="form-group autocomplete">
                <label for="user">Product(s):</label>
                <input
                    class="form-control product-search"
                    id="product"
                    name="product[]"
                    data-label="Product:"
                    multiple
                />
            </div>
        </div>

        <div class="card-footer">
            <input
                type="submit"
                class="btn btn-success btn-block"
                value="Get orders"
            />
        </div>
    </div>
</form>
