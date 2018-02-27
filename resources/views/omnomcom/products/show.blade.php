@extends('website.layouts.default')

@section('page-title')
    OmNomCom Product Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-3">

            <h3 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: center;">

                {{ $product->name }}

            </h3>

            <p style="text-align: center;">Currently in stock: <strong>{{ $product->stock }}</strong></p>

            @if($product->image != null)

                <div class="product__edit__image">
                    <div class="product__edit__image__inner"
                         style="background-image: url('{!! $product->image->generateImagePath(500, null) !!}');"></div>
                </div>

            @endif

            <hr>

            <div class="btn-group-justified">
                <a href="{{ route('omnomcom::products::edit', ['id' => $product->id]) }}" class="btn btn-success">
                    Edit OmNomCom Product
                </a>
            </div>

            @if ($product->ticket)

                <hr>

                <div class="btn-group-justified">
                    <a href="{{ route('tickets::edit', ['id' => $product->ticket->id]) }}" class="btn btn-success">
                        Edit Associated Event Ticket
                    </a>
                </div>

            @endif


        </div>

        <div class="col-md-9">

            <h3>Most recent orders for this product</h3>

            @if ($product->orderlines->count() > 0)

                <table class="table">

                    <thead>

                    <tr>

                        <th>Order time</th>
                        <th>User</th>
                        <th>Quantity</th>
                        <th>Total price</th>

                    </tr>

                    </thead>

                    @foreach($orderlines as $orderline)

                        <tr>

                            <td>{{ $orderline->created_at }}</td>
                            <td>
                                @if($orderline->user)

                                    <a href="{{ route('user::profile', ['id' => $orderline->user->getPublicId()]) }}">
                                        {{ $orderline->user->name }}
                                    </a>

                                @else

                                    [Cashier: {{ $orderline->cashier->name }}]

                                @endif
                            </td>
                            <td>{{ $orderline->units }}x</td>
                            <td>&euro; {{ number_format($orderline->total_price, 2) }}</td>

                        </tr>

                    @endforeach

                </table>

                <div style="text-align: center;">{!! $orderlines->render() !!}</div>

            @else

                <p style="text-align: center;">
                    There are no orders for this product.
                </p>

            @endif

        </div>

    </div>

@endsection