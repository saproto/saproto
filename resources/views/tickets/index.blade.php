@extends('website.layouts.default')

@section('page-title')
    Tickets Admin
@endsection

@section('content')

    @if (count($tickets) > 0)

        <p style="text-align: center;">
            <a href="{{ route('tickets::add') }}">Create a new ticket.</a>
        </p>

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Event</th>
                <th>Ticket Name</th>
                <th>Availability</th>
                <th>Who</th>
                <th>Sold</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($tickets as $ticket)

                <tr>

                    <td>{{ $ticket->id }}</td>
                    <td>
                        <a href="{{ route('event::show', ['id'=>$ticket->event->id]) }}">
                            {{ $ticket->event->title }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('omnomcom::products::show', ['id'=>$ticket->product->id]) }}">
                            {{ $ticket->product->name }}
                        </a>
                    </td>
                    <td>
                        {{ date('d-m-Y H:i', $ticket->available_from) }}
                        -
                        {{ date('d-m-Y H:i', $ticket->available_to) }}
                    </td>
                    <td>
                        {{ $ticket->members_only ? 'Members' : 'Everyone' }}
                    </td>
                    <td>{{ $ticket->sold() }} / {{ $ticket->totalAvailable() }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('tickets::edit', ['id' => $ticket->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('tickets::delete', ['id' => $ticket->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There are currently no tickets to display.
            <a href="{{ route('tickets::add') }}">Create a new ticket.</a>
        </p>

    @endif

@endsection