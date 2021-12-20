@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ $title }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                </div>

                <table class="table table-hover table-sm">

                    <thead>
                    <tr class="bg-dark text-white">
                        <td></td>
                        <td>Name</td>
                        <td>Total</td>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($accounts as $key => $account)

                        <tr class="cursor-pointer" data-bs-toggle="collapse" data-bs-target=".collapse-{{ $key }}">
                            <th>{{ $key }}</th>
                            <td>{{ $account->name }}</td>
                            <td>&euro; {{ number_format($account->total, 2) }}</td>

                        </tr>

                        @foreach($account->byDate as $date => $amount)
                            <tr class="collapse collapse-{{ $key }}">
                                <td></td>
                                <td>{{ $date }}</td>
                                <td>&euro; {{ number_format($amount, 2) }}</td>
                            </tr>
                        @endforeach

                    @endforeach

                    @if(isset($total))

                        <tr>
                            <td></td>
                            <td class="text-end">Total</td>
                            <td class="font-weight-bold">
                                &euro; {{ number_format($total, 2) }}
                            </td>

                        </tr>

                    @endif

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection