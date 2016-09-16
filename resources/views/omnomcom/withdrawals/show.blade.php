@extends('website.layouts.default')

@section('page-title')
    Withdrawal of {{ $withdrawal->date }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="row">

                <table class="table">

                    <thead>
                    <tr>
                        <th>User</th>
                        @if(!$withdrawal->closed)
                            <th>Bank Account</th>
                            <th>Authorization</th>
                        @endif
                        <th>#</th>
                        <th>Sum</th>
                    </tr>
                    </thead>

                    @foreach($withdrawal->users() as $user)

                        <tr>
                            <td>{{ $user->name }}</td>
                            @if(!$withdrawal->closed)
                                <td>
                                    <strong>{{ $user->bank->iban }}</strong>
                                    / {{ $user->bank->bic }}
                                </td>
                                <td>{{ $user->bank->machtigingid }}</td>
                            @endif
                            <td>{{ $withdrawal->orderlinesForUser($user)->count() }}</td>
                            <td>{{ number_format($withdrawal->totalForUser($user), 2, ',', '.') }}</td>
                        </tr>

                    @endforeach

                </table>

            </div>

        </div>

    </div>

@endsection