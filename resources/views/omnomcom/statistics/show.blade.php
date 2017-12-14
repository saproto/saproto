@extends('website.layouts.panel')

@section('page-title')
    Account Aggregation
@endsection

@section('panel-title')
    OmNomCom statistics for {{ $start }} - {{ $end }}
@endsection

@section('panel-body')

    <p>
        This table aggregates the total sale value for each product between the specified period.
    </p>

    <hr>

    <table class="table">

        <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Stock</th>
            <th>Sold</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody>

        @foreach($products as $key => $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $amounts[$key] }}</td>
                <td>&euro; {{ number_format($totals[$key], 2) }}</td>
            </tr>
        @endforeach

        </tbody>

    </table>

@endsection