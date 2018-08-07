@extends('website.layouts.default-nobg')

@section('page-title')
    Overview of Mollie Transactions
@endsection

@section('content')

    <div class="row">

        <div class="col-md-7">

            <div class="panel">
                <div class="panel-heading">
                    Transactions
                </div>
                <div class="panel-body">

                    @if(count($transactions) > 0)

                        <table class="table">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Amount</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($transactions as $transaction)

                                <tr>
                                    <td>
                                        <a href='{{ route('omnomcom::mollie::status', ['id' => $transaction->id]) }}'>
                                            #{{$transaction->id}}
                                        </a>
                                    </td>

                                    <td>
                                        <strong>&euro;</strong> {{ number_format($transaction->amount, 2, '.', '') }}
                                    </td>

                                    <td>
                                        <a href="{{ route('user::dashboard', ['id' => $transaction->user->id]) }}">
                                            {{ $transaction->user->name }}
                                        </a>
                                    </td>

                                    <td>
                                        @if(MollieTransaction::translateStatus($transaction->status) == 'open')
                                            <span class="label label-default">{{ $transaction->status }}</span>
                                        @elseif(MollieTransaction::translateStatus($transaction->status) == 'paid')
                                            <span class="label label-success">{{ $transaction->status }}</span>
                                        @elseif(MollieTransaction::translateStatus($transaction->status) == 'failed')
                                            <span class="label label-danger">{{ $transaction->status }}</span>
                                        @else
                                            <span class="label label-warning">{{ $transaction->status }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ date('Y-m-d', strtotime($transaction->created_at)) }}
                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                        <div style="text-align: center;">{{ $transactions->links() }}</div>

                    @else

                        <div class="list-group">

                            <li class="list-group-item">
                                There's no transactions.
                            </li>

                        </div>

                    @endif

                </div>
            </div>

        </div>

        <div class="col-md-5">

            <div class="panel">
                <div class="panel-heading">
                    Account overview
                </div>
                <div class="panel-body">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                        @for($m = 0; $m <= 11 ; $m++)
                            <?php
                            $month = strtotime(sprintf('-%s months', $m));
                            $total = MollieController::getTotalForMonth(date('Y-m', $month));
                            ?>
                            <tr>
                                <td>
                                    <a href="{{ route('omnomcom::mollie::monthly', ['month' => date('Y-m', $month)]) }}">
                                        <span class="gray">{{ date('F Y', strtotime(sprintf('-%s months', $m))) }}</span>
                                    </a>
                                </td>
                                <td style="text-align: right">
                                    @if ($total > 0)
                                        <span class="label label-success">
                                             &euro; {{ number_format($total,2) }}
                                        </span>
                                    @else
                                        <span class="label label-default">no transactions</span>
                                    @endif
                                </td>
                            </tr>
                        @endfor

                        </tbody>
                    </table>

                </div>
            </div>

        </div>

    </div>

@endsection
