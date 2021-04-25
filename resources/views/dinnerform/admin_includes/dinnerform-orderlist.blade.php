@extends('website.layouts.redesign.generic')

@section('page-title')
    Dinnerform Orderlist
@endsection

@section('container')
<div class="card mb-3">

    <div class="card-header bg-dark text-white mb-1">
        Dinnerform overview Orders
    </div>

    <table class="table table-sm">

        <thead>

        <tr class="bg-dark text-white">
            <td>Member Name</td>
            <td>Member ID</td>
            <td>Price</td>
            <td></td>
        </tr>

        </thead>
        <tbody>

        @if(count($orders) > 0)
            @foreach($orders as $order)
                <tr>
                    #order description toevoegen
                    <td class="align-middle">{{$order->user->name}}</td>
                    <td class="align-middle">{{$order->user_id}} <span class="text-muted"></span></td>
                    <td class="align-middle">€{{$order->price}}<span class="text-muted"></span></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>There are no orders available.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif

        </tbody>

    </table>
</div>
@endsection
