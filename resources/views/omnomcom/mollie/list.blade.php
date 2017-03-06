@extends('website.layouts.default-nobg')

@section('page-title')
    Overview of Mollie Transactions
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel">
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
                                        {{ date(' Y-m-d H:i:s', strtotime($transaction->updated_at)) }}
                                    </td>

                                </tr>

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

    </div>

@endsection