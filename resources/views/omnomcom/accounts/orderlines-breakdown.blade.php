@extends('website.layouts.default')

@section('page-title')
    {{ $title }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <table class="table table-hover">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Total</th>
                </tr>
                </thead>

                <tbody>

                @foreach($accounts as $key => $account)

                    <tr data-toggle="collapse" data-target=".{{ $key }}" style="cursor: pointer;">
                        <th>{{ $key }}</th>
                        <th>{{ $account->name }}</th>
                        <th>&euro; {{ number_format($account->total, 2) }}</th>

                    </tr>

                    @foreach($account->byDate as $date => $amount)
                        <tr class="collapse {{ $key }}">
                            <td></td>
                            <td>{{ $date }}</td>
                            <td>&euro; {{ number_format($amount, 2) }}</td>
                        </tr>
                    @endforeach

                @endforeach

                @if(isset($total))

                    <tr>
                        <th>&nbsp;</th>
                        <th style="text-align: right;"><br>Total</th>
                        <th><br>&euro; {{ number_format($total, 2) }}</th>

                    </tr>

                @endif

                </tbody>

            </table>

        </div>

    </div>

@endsection