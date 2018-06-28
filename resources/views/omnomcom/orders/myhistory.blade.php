@extends('website.layouts.default-nobg')

@section('page-title')
    Purchase Overview for {{ date('F Y', strtotime($selected_month)) }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-3 col-md-push-9">

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

                @if($next_withdrawal > 0)
                    <div class="panel-footer">
                        <a class="btn btn-success" style="width: 100%;" href="{{ route('omnomcom::mollie::pay') }}"
                           data-toggle="modal" data-target="#mollie-modal">
                            Pay Outstanding Balance
                        </a>
                    </div>
                @endif

            </div>

            <div id="mollie-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Pay Outstanding Balance</h4>
                        </div>
                        <div class="modal-body">
                            <p>
                                Using this service you can pay your outstanding balance using our external payment
                                provider Mollie. Using Mollie you can pay your outstanding balance using iDeal,
                                CreditCard, Bitcoin and various German and Belgien payment providers.
                            </p>
                            <p>
                                <strong>Important!</strong> Using this service you will incur a transaction fee on top
                                of your outstanding balance. This transaction fee is
                                €{{ number_format(config('omnomcom.mollie')['fixed_fee'], 2) }} per transaction
                                plus {{ number_format(config('omnomcom.mollie')['variable_fee']*100, 2) }}% of the total
                                transaction. This transaction will appear in your OmNomCom history after payment.
                            </p>
                            <p>
                                If you wish to pay only a part of your outstanding balance, please use the field below
                                to indicate the maximum amount you would like to pay.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <form method="post" action="{{ route('omnomcom::mollie::pay') }}">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">&euro;</div>
                                            <input type="number" name="cap" class="form-control pull-left"
                                                   value="{{ number_format(ceil($next_withdrawal), 2, '.', '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Pay</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                    @if($withdrawal->getFailedWithdrawal($user))
                                        <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>
                                    @endif
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

            <div class="panel panel-default">

                <div class="panel-heading">
                    Mollie Payments
                </div>

                <div class="panel-body">

                    <table class="table">
                        <tbody>
                        @foreach($user->mollieTransactions as $transaction)
                            <tr style="{{ MollieTransaction::translateStatus($transaction->status) == "failed" ? "opacity: 0.3;" : "" }}">
                                <td>
                                    <a href="{{ route('omnomcom::mollie::status', ['id' => $transaction->id]) }}">
                                        {{ date('d-m-Y H:i', strtotime($transaction->created_at)) }}
                                    </a>
                                </td>
                                <td style="text-align: right;">
                                    &euro;{{ number_format($transaction->amount, 2, '.', ',') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

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

        <div class="col-md-9 col-md-pull-3">

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

                            <div class="col-md-2" style="text-align: right;">
                                {!! $orderline->generateHistoryStatus() !!}
                            </div>

                            <div class="col-md-2" style="text-align: right; opacity: 0.5;">
                                {{ date('H:i:s', strtotime($orderline->created_at)) }}
                            </div>

                        </div>

                        @if ($orderline->description)

                            <div class="row">

                                <div class="col-md-10 col-md-offset-2">
                                    <span style="color: #ccc; font-size: 12px;">
                                        {{ $orderline->description }}
                                    </span>
                                </div>

                            </div>

                        @endif

                    </li>

                    @endforeach

                </div>

            @else

                <div class="list-group">

                    <li class="list-group-item">
                        You didn't buy anything in this month.
                    </li>

                </div>

            @endif

        </div>

    </div>

@endsection