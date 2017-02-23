@extends('website.layouts.default')

@section('page-title')
    Unwithdrawable orderlines
@endsection

@section('content')

    <div class="row">

        <p style="text-align: center;">
            These orderlines cannot be withdrawn because they are associated with a user that doesn't have an active
            withdrawal authorization anymore.
        </p>

        <div class="col-md-8 col-md-offset-2">

            <table class="table table-hover">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Total</th>
                    <th>Transaction Date</th>
                </tr>
                </thead>

                <tbody>

                @foreach($users as $key => $user)

                    <tr data-toggle="collapse" data-target=".{{ $key }}" style="cursor: pointer;">
                        <th>{{ $key }}</th>
                        <th>{{ $user->user->name }}</th>
                        <th>&euro; {{ number_format($user->total, 2) }}</th>
                        <th></th>

                    </tr>

                    @foreach($user->orderlines as $orderline)
                        <tr class="collapse {{ $key }}">
                            <td>{{ $orderline->id }}</td>
                            <td>{{ $orderline->units }}x {{ $orderline->product->name }}</td>
                            <td>&euro; {{ number_format($orderline->total_price, 2) }}</td>
                            <td>{{ $orderline->created_at }}</td>
                        </tr>
                    @endforeach

                @endforeach
                </tbody>

            </table>

        </div>

    </div>

@endsection