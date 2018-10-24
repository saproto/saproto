@extends('website.layouts.default')

@section('page-title')
    Withdrawal Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <p style="text-align: center;">
                <a href="{{ route('omnomcom::withdrawal::add') }}">Create a new withdrawal.</a>
            </p>

            <hr>

            @if ($withdrawals->count() > 0)

                <table class="table">

                    <thead>

                    <tr>

                        <th>#</th>
                        <th>ID</th>
                        <th>Withdrawal Date</th>
                        <th>Users</th>
                        <th>Orderlines</th>
                        <th>Sum</th>
                        <th>Status</th>
                        <th>View</th>

                    </tr>

                    </thead>

                    @foreach($withdrawals as $withdrawal)

                        <tr>

                            <td>
                                <a href="{{ route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]) }}">
                                    {{ $withdrawal->id }}
                                </a>
                            </td>
                            <td>{{ $withdrawal->withdrawalId() }}</td>
                            <td>{{ $withdrawal->date }}</td>
                            <td>{{ $withdrawal->userCount() }}</td>
                            <td>{{ $withdrawal->orderlines->count() }}</td>
                            <td>&euro;{{ number_format($withdrawal->total(), 2, ',', '.') }}</td>
                            <td>{{ $withdrawal->closed ? 'Closed' : 'Pending' }}</td>
                            <td>
                                <a href="{{ route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]) }}">
                                    Withdrawal
                                </a>

                                /

                                <a href="{{ route('omnomcom::withdrawal::showAccounts', ['id' => $withdrawal->id]) }}">
                                    Accounts
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

                <div style="text-align: center;">{{ $withdrawals->links() }}</div>

            @else

                <p style="text-align: center;">
                    There are no withdrawals.
                </p>

            @endif

        </div>

    </div>

@endsection