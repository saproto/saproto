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


        </div>

        <div class="col-md-9">

            <h3>Most recent orders for this product</h3>

            @if ($product->orderlines->count() > 15)

                <p>
                    Only showing the last 15 out of {{ $product->orderlines->count() }} orders.
                </p>

            @endif

            @if ($product->orderlines->count() > 0)

                <table class="table">

                    <thead>

                    <tr>

                        <th>Order time</th>
                        <th>User</th>
                        <th>Quantity</th>

                    </tr>

                    </thead>

                    @foreach($product->orderlines->slice(0, 15)->all() as $orderline)

                        <tr>

                            <td>{{ $orderline->created_at }}</td>
                            <td>
                                <a href="{{ route('user::profile', ['id' => $orderline->user->id]) }}">
                                    {{ $orderline->user->name }}
                                </a>
                            </td>
                            <td>{{ $orderline->units }}x</td>

                        </tr>

                    @endforeach

                </table>

            @else

                <p style="text-align: center;">
                    There are no orders for this product.
                </p>

            @endif

        </div>

    </div>

@endsection