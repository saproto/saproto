@extends('website.layouts.default')

@section('page-title')
    OmNomCom Product Administration
@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        $("#product-search-submit").click(function () {
            document.getElementById('product-search-form').submit();
        });

    </script>

@endsection

@section('content')

    <div class="row">

        <div class="col-md-3">

            <div class="form-group">

                <form id="product-search-form" method="get" action="{{ route("omnomcom::products::list") }}">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search">
                        <span id="product-search-submit" class="input-group-addon" style="cursor: pointer;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </span>
                    </div>
                </form>

            </div>

            <hr>

            <div class="btn-group btn-group-justified">

                <a href="{{ route('omnomcom::products::add') }}" class="btn btn-success">Create a new product</a>

            </div>

            <hr>

            <form method="post" action="{{ route("omnomcom::products::bulkupdate") }}">

                {!! csrf_field() !!}

                <p>
                    Bulk update stock by inserting a comma-seperated list of product_id's and the amount you want to
                    add.
                </p>

                <textarea name="update" style="width: 100%;" rows="7"></textarea>

                <input type="submit" class="btn btn-success" value="Bulk update stock" style="width: 100%;">

            </form>

            <hr>

            <div class="btn-group btn-group-justified">

                <a href="{{ route('omnomcom::products::export_csv') }}" class="btn btn-success">Export all as CSV</a>

            </div>


        </div>

        <div class="col-md-8 col-md-offset-1">

            @if (count($products) > 0)

                <table class="table">

                    <thead>

                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Visible</th>
                        <th>Alcoholic</th>

                    </tr>

                    </thead>

                    @foreach($products as $product)

                        <tr>

                            <td>{{ $product->id }}</td>
                            <td>
                                <a href="{{ route('omnomcom::products::show', ['id' => $product->id]) }}">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->is_visible }}</td>
                            <td>{{ $product->is_alcoholic }}</td>
                            <td>
                                <a class="btn btn-xs btn-default"
                                   href="{{ route('omnomcom::products::edit', ['id' => $product->id]) }}" role="button">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a class="btn btn-xs btn-danger"
                                   onclick="return confirm('Remove product \'{{ $product->name }}\'?');"
                                   href="{{ route('omnomcom::products::delete', ['id' => $product->id]) }}"
                                   role="button">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

                @if($paginate)

                    <div style="margin: 0 auto;">
                        {!! $products->render() !!}
                    </div>

                @endif

            @else

                <p style="text-align: center;">
                    There are no products matching your query.
                </p>

            @endif

        </div>

    </div>

@endsection