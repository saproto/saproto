@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Tickets Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a href="{{ route('tickets::add') }}" class="badge badge-info float-right">Create a new ticket.</a>
                </div>

                <table class="table table-sm table-borderless table-hover">

                    <thead>

                    <tr class="bg-dark text-white">

                        <td class="pl-3">Event</td>
                        <td>Ticket Name</td>
                        <td>Availability</td>
                        <td>Who</td>
                        <td>Sold</td>
                        <td>Controls</td>

                    </tr>

                    </thead>

                    @foreach($tickets as $ticket)

                        <tr>

                            <td class="pl-3">
                                <a href="{{ route('event::show', ['id'=>$ticket->event->getPublicId()]) }}">
                                    {{ $ticket->event->title }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('omnomcom::products::edit', ['id'=>$ticket->product->id]) }}">
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
                                <a href="{{ route('tickets::edit', ['id' => $ticket->id]) }}">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </a>
                                <a class="text-danger ml-2" href="{{ route('tickets::delete', ['id' => $ticket->id]) }}">
                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

                <div class="card-footer pb-0">
                    {{ $tickets->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection