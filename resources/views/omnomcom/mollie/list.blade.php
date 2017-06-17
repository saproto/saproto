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
                                <th>Updated</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($transactions as $transaction)

                                @if($transaction->status == "paid" || $transaction->status == "paidout" || $transaction->status == "open")

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
                                            {{ date('Y-m-d', strtotime($transaction->updated_at)) }}
                                        </td>

                                    </tr>

                                @endif

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="list-group">

                            <li class="list-group-item">
                                There's no transactions.
                            </li>

                        </div>

                    @endif

                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    Failed
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
                                <th>Updated</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($transactions as $transaction)

                                @if($transaction->status != "paid" && $transaction->status != "paidout" && $transaction->status != "open")

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
                                            {{ date('Y-m-d', strtotime($transaction->updated_at)) }}
                                        </td>

                                    </tr>

                                @endif

                            @endforeach

                            </tbody>

                        </table>

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

                    <table class="table table-hover">

                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($accounts as $key => $month)

                            <tr data-toggle="collapse" data-target=".{{ $key }}" style="cursor: pointer;">
                                <th>{{ $month->name }}</th>
                                <th>&euro; {{ number_format($month->total, 2) }}</th>

                            </tr>

                            @foreach($month->byAccounts as $account => $data)
                                <tr class="collapse {{ $key }}">
                                    <td>{{ $data->name }}</td>
                                    <td>&euro; {{ number_format($data->total, 2) }}</td>
                                </tr>
                            @endforeach

                        @endforeach
                        </tbody>

                    </table>

                    <p>
                        <strong>Important</strong> Remember that this overview calculates the totals based on the
                        transaction date of the <strong>orderline</strong>, not the <strong>Mollie payment</strong>.
                    </p>

                </div>
            </div>

        </div>

    </div>

@endsection