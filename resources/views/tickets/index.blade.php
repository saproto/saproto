@extends('website.layouts.default')

@section('page-title')
    Tickets Admin
@endsection

@section('content')

    @if (count($tickets) > 0)

        <p style="text-align: center;">
            <a href="{{ route('tickets::add') }}">Create a new ticket.</a>
        </p>

        <strong class="visible-sm visible-xs" style="text-align: center;">- Some columns have been hidden because the screen is too small -</strong>

        <table class="table">

            <thead>

                <tr>

                    <th class="hidden-sm hidden-xs">#</th>
                    <th class="hidden-sm hidden-xs">Event</th>
                    <th>Ticket Name</th>
                    <th class="hidden-sm hidden-xs">Availability</th>
                    <th class="hidden-sm hidden-xs">Who</th>
                    <th class="hidden-sm hidden-xs">Sold</th>
                    <th>Controls</th>

                </tr>

            </thead>

            @foreach($tickets as $ticket)

                <tr>

                    <td class="hidden-sm hidden-xs">{{ $ticket->id }}</td>
                    <td class="hidden-sm hidden-xs">
                        <a href="{{ route('event::show', ['id'=>$ticket->event->getPublicId()]) }}">
                            {{ $ticket->event->title }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('omnomcom::products::show', ['id'=>$ticket->product->id]) }}">
                            {{ $ticket->product->name }}
                        </a>
                    </td>
                    <td class="hidden-sm hidden-xs">
                        {{ date('d-m-Y H:i', $ticket->available_from) }}
                        -
                        {{ date('d-m-Y H:i', $ticket->available_to) }}
                    </td>
                    <td class="hidden-sm hidden-xs">
                        {{ $ticket->members_only ? 'Members' : 'Everyone' }}
                    </td>
                    <td class="hidden-sm hidden-xs">{{ $ticket->sold() }} / {{ $ticket->totalAvailable() }}</td>
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