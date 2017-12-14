@extends('website.layouts.default')

@section('page-title')
    OmNomCom Account Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-3">

            <h3 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: center;">

                {{ $account->name }}

            </h3>

            <p style="text-align: center;">Account number: <strong>{{ $account->account_number }}</strong></p>

            <hr>

            <form method="post" action="{{ route('omnomcom::accounts::aggregate', ['account' => $account->id]) }}">

                {!! csrf_field() !!}

                <p><strong>Aggregated sales overview</strong></p>

                <div class="form-group">
                    <label for="start">Start</label>
                    <input type="text" class="form-control datetime-picker" id="start" name="start" required>
                </div>

                <div class="form-group">
                    <label for="end">End</label>
                    <input type="text" class="form-control datetime-picker" id="end" name="end" required>
                </div>

                <button type="submit" class="btn btn-success">Generate</button>

            </form>

        </div>

        <div class="col-md-9">

            <h3>Products linked to this account</h3>

            <p><strong>{{ $products->count() }}</strong> products</p>

            <hr>

            @if ($products->count() > 0)

                <div style="margin: 0 auto;">
                    {!! $products->render() !!}
                </div>

                <div class="row">

                    @foreach($products as $product)

                        <div class="col-md-4 product__account">

                            <div class="product__account__image">

                                @if($product->image != null)

                                    <div class="product__account__image__inner"
                                         style="background-image: url('{!! $product->image->generateImagePath(500, null) !!}');">
                                    </div>

                                @endif

                            </div>

                            <div class="product__account__name">

                                <a href="{{ route("omnomcom::products::show",['id' => $product->id]) }}">{{ $product->name }}</a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <p style="text-align: center;">
                    There are no products for this account.
                </p>

            @endif

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                next: "fa fa-chevron-right",
                previous: "fa fa-chevron-left"
            },
            format: 'DD-MM-YYYY HH:mm'
        });
    </script>

@endsection