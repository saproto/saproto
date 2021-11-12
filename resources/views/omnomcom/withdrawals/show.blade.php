@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Withdrawal of {{ date('d-m-Y', strtotime($withdrawal->date)) }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-3">

            <form method="post" action="{{ route('omnomcom::withdrawal::edit', ['id' => $withdrawal->id]) }}">

                {!! csrf_field() !!}

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white mb-2">
                        @yield('page-title')
                    </div>

                    <table class="table table-sm table-borderless ms-3">

                        <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $withdrawal->withdrawalId() }}</td>
                        </tr>
                        <tr>
                            <th>Users</th>
                            <td>{{ $withdrawal->users()->count() }}</td>
                        </tr>
                        <tr>
                            <th>Orderlines</th>
                            <td>{{ $withdrawal->orderlines->count() }}</td>
                        </tr>
                        <tr>
                            <th>Sum</th>
                            <td>&euro;{{ number_format($withdrawal->total(), 2) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $withdrawal->closed ? 'Closed' : 'Pending' }}</td>
                        </tr>
                        </tbody>

                    </table>

                    <div class="card-body">
                        <label>Change date:</label>
                        @include('website.layouts.macros.datetimepicker', [
                            'name' => 'date',
                            'format' => 'date',
                            'placeholder' => strtotime($withdrawal->date)
                        ])
                    </div>

                    <div class="card-footer">

                        <input type="submit" value="Save" class="btn btn-success btn-block">

                        <a href="{{ route('omnomcom::withdrawal::export', ['id' => $withdrawal->id]) }}"
                           class="btn btn-outline-success btn-block">
                            Generate XML
                        </a>

                        <a href="{{ route('omnomcom::withdrawal::email', ['id' => $withdrawal->id]) }}"
                           class="btn btn-outline-warning btn-block"
                           onclick="return confirm('This will send an e-mail to {{ $withdrawal->users()->count() }} users. Are you sure?');">
                            E-mail Users
                        </a>

                        <a href="{{ route('omnomcom::withdrawal::close', ['id' => $withdrawal->id]) }}"
                           class="btn btn-outline-danger btn-block"
                           onclick="return confirm('After closing, you cannot change anything about this withdrawal. Are you sure?');">
                            Close Withdrawal
                        </a>

                        <a href="{{ route('omnomcom::withdrawal::delete', ['id' => $withdrawal->id]) }}"
                           class="btn btn-outline-danger btn-block" onclick="return confirm('Are you sure?');">
                            Delete
                        </a>

                    </div>

                </div>

            </form>

        </div>

        <div class="col-md-9">

            <div class="card mb-3">

                <div class="card-header mb-1 bg-dark text-white">
                    Users in this withdrawal
                </div>

                <table class="table table-sm table-hover">

                    <thead>
                    <tr class="bg-dark text-white">
                        <td>User</td>
                        @if(!$withdrawal->closed)
                            <td>Bank Account</td>
                            <td>Authorization</td>
                        @endif
                        <td>#</td>
                        <td>Sum</td>
                        @if(!$withdrawal->closed)
                            <td>Controls</td>
                        @endif
                    </tr>
                    </thead>

                    @foreach($withdrawal->totalsPerUser() as $data)

                        <tr>
                            <td>{{ $data->user->name }}</td>
                            @if(!$withdrawal->closed)
                                <td>
                                    <strong>{{ $data->user->bank->iban }}</strong>
                                    / {{ $data->user->bank->bic }}
                                </td>
                                <td>{{ $data->user->bank->machtigingid }}</td>
                            @endif
                            <td>{{ $data->count }}</td>
                            <td>&euro;{{ number_format($data->sum, 2, ',', '.') }}</td>
                            @if(!$withdrawal->closed)
                                <td>
                                    @if($withdrawal->getFailedWithdrawal($data->user))
                                        Failed
                                        <a onclick="return confirm('Are you sure? The user will NOT receive an e-mail about this?')"
                                           href="{{ route('omnomcom::orders::delete', ['id'=>$withdrawal->getFailedWithdrawal($data->user)->correction_orderline_id]) }}">
                                            (Revert)
                                        </a>
                                    @else
                                        <a href="{{ route('omnomcom::withdrawal::deleteuser', ['id' => $withdrawal->id, 'user_id' => $data->user->id]) }}">
                                            Remove
                                        </a>

                                        or

                                        <a href="{{ route('omnomcom::withdrawal::markfailed', ['id' => $withdrawal->id, 'user_id' => $data->user->id]) }}"
                                           onclick="return confirm('You are about to mark the withdrawal for {{ $data->user->name }} as failed. They will receive an e-mail. Are you sure?');">
                                            Mark Failed
                                        </a>
                                    @endif
                                </td>
                            @endif
                        </tr>

                    @endforeach

                </table>

            </div>

        </div>

    </div>

@endsection