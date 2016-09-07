@extends('website.layouts.panel')

@section('page-title')
    Account Aggregation
@endsection

@section('panel-title')
    Account aggregation for account number {{ $account->account_number }}: {{ $account->name }}.
@endsection

@section('panel-body')

    <p>
        This table aggregates the total sale value for each product between the specified period.
    </p>

    <p>
        Start: {{ $start }}<br>
        End: {{ $end }}
    </p>

    <hr>

    <table class="table">

        <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Aggregated income</th>
        </tr>
        </thead>

        <tbody>

        @foreach($products as $key => $product)
            <tr>
                <td>{{ $product->id }} ({{ $key }})</td>
                <td>{{ $product->name }}</td>
                <td>&euro;{{ number_format($totals[$key], 2) }}</td>
            </tr>
        @endforeach

        </tbody>

    </table>

@endsection