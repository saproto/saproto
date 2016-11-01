@extends('website.layouts.default')

@section('page-title')
    Accounts of withdrawal of {{ date('d-m-Y', strtotime($withdrawal->date)) }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <table class="table">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Total</th>
                </tr>
                </thead>

                <tbody>

                @foreach($accounts as $key => $account)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ $account->name }}</td>
                        <td>&euro; {{ number_format($account->total, 2) }}</td>

                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

    </div>

@endsection