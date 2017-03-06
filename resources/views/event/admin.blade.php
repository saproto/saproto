@extends('website.layouts.default')

@section('page-title')
    Event Admin
@endsection

@section('content')

    @if (count($event->tickets) > 0)

        <p style="text-align: center;">
            <a class="form-control btn btn-success" href="{{ route('event::scan', ['id' => $event->id]) }}">
                Start Scanner Application for Event
            </a>
        </p>

        @foreach($event->tickets as $ticket)

            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" href="#ticket-{{ $ticket->id }}"
                     style="cursor: pointer;">
                    <h1 class="panel-title">
                        <strong>{{ $ticket->product->name }}</strong>
                        <span class="label label-success pull-right">
                            {{ $ticket->sold() }} sold / {{ $ticket->product->stock }} available
                        </span>
                        <span class="label label-info pull-right" style="margin-right: 10px;">
                            &euro;{{ number_format($ticket->turnover(), 2) }}
                        </span>
                    </h1>
                </div>
                <div id="ticket-{{ $ticket->id }}" class="panel-collapse collapse" role="tabpanel">

                    @if ($ticket->purchases->count() > 0)
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Price</th>
                                <th>Date of Purchase</th>
                                <th>Ticket Scanned</th>
                                @if (Auth::user()->can('board'))
                                    <th>Delete Ticket</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ticket->purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ $purchase->user->name }}</td>
                                    <td>&euro;{{ number_format($purchase->orderline->total_price, 2) }}</td>
                                    <td>{{ $purchase->created_at }}</td>
                                    <td>
                                        @if ($purchase->scanned === null)
                                            <a href="{{ route('tickets::scan', ['barcode' => $purchase->barcode]) }}">
                                                Scan Manually
                                            </a>
                                        @else
                                            {{ $purchase->scanned }} /
                                            <a href="{{ route('tickets::unscan', ['barcode' => $purchase->barcode]) }}">
                                                Unscan
                                            </a>
                                        @endif
                                    </td>
                                    @if (Auth::user()->can('board'))
                                        <td>
                                            @if($purchase->orderline->isPayed())
                                                Already Paid
                                            @elseif($purchase->scanned)
                                                Already Used
                                            @else
                                                <a href="{{ route('omnomcom::orders::delete', ['id'=>$purchase->orderline->id]) }}"
                                                   onclick="return confirm('Are you sure you want to delete on ticket for {{ $purchase->user->name }}?')">
                                            <span class="label label-danger">
                                                Delete
                                            </span>
                                                </a>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="panel-body">
                            <p style="text-align: center">
                                This ticket has not sold yet.
                            </p>
                        </div>
                    @endif

                </div>
            </div>

        @endforeach

    @else

        <p style="text-align: center;">
            This event has no ticket sale associated.
        </p>

    @endif

@endsection