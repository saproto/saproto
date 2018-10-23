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



        </div>

        <div >

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

                                    @if($orderline->user->isMember)
                                        <a href="{{ route('user::profile', ['id' => $orderline->user->getPublicId()]) }}">
                                            {{ $orderline->user->name }}
                                        </a>
                                    @else
                                        {{ $orderline->user->name }}
                                    @endif

                                @else

                                    [Cashier: {{ $orderline->cashier->name }}]

                                @endif

                                @if ($orderline->description)
                                    <span style="color: #ccc; font-size: 12px;">
                                        <br>{{ $orderline->description }}
                                    </span>
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