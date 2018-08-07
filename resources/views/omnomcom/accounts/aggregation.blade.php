@extends('website.layouts.panel')

@section('page-title')
    Account Aggregation
@endsection

@section('panel-title')
    <strong>{{ $account->name }}</strong> account aggregation
@endsection

@section('panel-body')

    <p>
        This table aggregates the total sales values for each product in the <strong>{{ $account->name }}</strong>
        account between <strong>{{ $start }} - {{ $end }}</strong>.
    </p>

    <hr>

    <table class="table">

        <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Units</th>
            <th>Turnover</th>
        </tr>
        </thead>

        <tbody>

        @foreach($aggregation as $key => $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->number_sold }}</td>
                <td>&euro; {{ number_format($product->total_turnover, 2) }}</td>
            </tr>
        @endforeach

        </tbody>

    </table>

@endsection