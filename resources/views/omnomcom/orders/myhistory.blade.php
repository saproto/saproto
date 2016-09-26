@extends('website.layouts.default-nobg')

@section('page-title')
    Purchase Overview for {{ date('F Y', strtotime($selected_month)) }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-3">

            <p style="text-align: center; margin-bottom: 20px; padding: 10px 0; color: #fff; background-color: #222;">
                Overview for {{ $user->name }}
            </p>

            <div class="panel panel-default">

                <div class="panel-heading">
                    History
                </div>

                <div class="panel-body">

                    @foreach($available_months as $year => $months)

                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ $year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($months as $month)
                                <tr>
                                    <td>
                                        <a href="{{ route("omnomcom::orders::list", ['user_id' =>$user->id, 'month' => $month]) }}">
                                            {{ date('F Y', strtotime($month)) }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @endforeach

                </div>

            </div>

        </div>

        <div class="col-md-6">

            @if(count($orderlines) > 0)

                <?php
                $total = 0;
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

                        <?php $total += $orderline->total_price; ?>

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

                <?php
                $total = 0;
                ?>

                <div class="list-group">

                    <li class="list-group-item">
                        You didn't buy anything in this month.
                    </li>

                </div>

            @endif

        </div>

        <div class="col-md-3">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Total for {{ date('F Y', strtotime($selected_month)) }}
                </div>

                <div class="panel-body">

                    <p style="font-weight: 700; font-size: 50px;">
                        &euro; {{ number_format($total, 2, '.', '') }}
                    </p>

                </div>

            </div>

            <div class="panel panel-default">

                <div class="panel-heading">
                    Next withdrawal
                </div>

                <div class="panel-body">

                    <p style="font-weight: 700; font-size: 50px;">
                        &euro; {{ number_format($next_withdrawal, 2, '.', '') }}
                    </p>

                </div>

            </div>

            <div class="panel panel-default">

                <div class="panel-heading">
                    Withdrawals
                </div>

                <div class="panel-body">

                    <table class="table">
                        <tbody>
                        @foreach($user->withdrawals() as $withdrawal)
                            <tr>
                                <td>
                                    <a href="{{ route('omnomcom::mywithdrawal', ['id' => $withdrawal->id]) }}">
                                        {{ date('d-m-Y', strtotime($withdrawal->date)) }}
                                    </a>
                                </td>
                                <td style="text-align: right;">
                                    &euro;{{ number_format($withdrawal->totalForUser($user), 2, '.', ',') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection