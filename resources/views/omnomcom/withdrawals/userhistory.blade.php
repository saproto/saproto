@extends('website.layouts.default-nobg')

@section('page-title')
    Personal Overview for the {{ date('d-m-Y', strtotime($withdrawal->date)) }} Withdrawal
@endsection

@section('content')

    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            @if($withdrawal->getFailedWithdrawal(Auth::user()))

                <p style="text-align: center; margin-bottom: 20px; padding: 10px 0; color: #fff; background-color: red;">
                    <i class="fas fa-times" aria-hidden="true"></i> This withdrawal has failed.
                </p>

            @endif

            <p style="text-align: center; margin-bottom: 20px; padding: 10px 0; color: #fff; background-color: #222;">
                Withdrawal total: &euro;{{ number_format($withdrawal->totalForUser(Auth::user()), 2, '.', ',') }}
            </p>

            @if(count($orderlines) > 0)

                <?php
                $current_date = date('d-m-Y', strtotime($orderlines[0]->created_at));
                ?>

                <div class="list-group">

                    <li class="list-group-item list-group-item-success">{{ date('l F jS', strtotime($current_date)) }}</li>

                    @foreach($orderlines as $orderline)

                        @if(date('d-m-Y', strtotime($orderline->created_at)) != $current_date)

                </div>
                <div class="list-group">

                    <?php $current_date = date('d-m-Y', strtotime($orderline->created_at)); ?>
                    <li class="list-group-item list-group-item-success">{{ date('l F jS', strtotime($current_date)) }}</li>

                    @endif

                    <li class="list-group-item">


                        <div class="row">

                            <div class="col-md-2">
                                <strong>&euro;</strong> {{ number_format($orderline->total_price, 2, '.', '') }}
                            </div>

                            <div class="col-md-6"
                                 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $orderline->units }}x <strong>{{ $orderline->product->name }}</strong>
                            </div>

                            <div class="col-md-4" style="text-align: right; opacity: 0.5;">
                                {{ date('H:i:s', strtotime($orderline->created_at)) }}
                            </div>

                        </div>

                    </li>

                    @endforeach

                </div>

            @else

                <div class="list-group">

                    <li class="list-group-item">
                        You are not included in this withdrawal.
                    </li>

                </div>

            @endif

        </div>

    </div>

@endsection