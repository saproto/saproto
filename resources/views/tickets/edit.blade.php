@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($ticket == null ? "Create new ticket." : "Edit tick " . $ticket->product->name .".") }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <form method="post"
                  action="{{ ($ticket == null ? route("tickets::add") : route("tickets::edit", ['id' => $ticket->id])) }}"
                  enctype="multipart/form-data">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white mb-1">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="product">Product:</label>
                            @if($ticket)
                                &nbsp; <i>{{ $ticket->product->name }}</i>
                            @endif
                            <select class="form-control product-search" id="product"
                                    name="product" {{ $ticket ? '' : 'required' }}></select>
                        </div>

                        <div class="form-group">
                            <label for="event">Event:</label>
                            @if($ticket)
                                &nbsp; <i>{{ $ticket->event->title }}
                                    ({{ $ticket->event->getFormattedDateAttribute()->simple }})</i>
                            @endif
                            <select class="form-control event-search" id="event"
                                    name="event" {{ $ticket ? '' : 'required' }}></select>
                        </div>

                        <div class="form-group">
                            <label for="available_from">Available from:</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'available_from',
                                'format' => 'datetime',
                                'placeholder' => $ticket ? $ticket->available_from : null
                            ])
                        </div>

                        <div class="form-group">
                            <label for="available_to">Available to:</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'available_to',
                                'format' => 'datetime',
                                'placeholder' => $ticket ? $ticket->available_to : null
                            ])
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="is_members_only" {{ ($ticket && $ticket->members_only ? 'checked' : '') }}>
                                Available to members only.
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="is_prepaid" {{ ($ticket && $ticket->is_prepaid ? 'checked' : '') }}>
                                This ticket should be prepaid.
                            </label>
                        </div>

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-right">Submit</button>

                        <a href="{{ route("tickets::list") }}" class="btn btn-default">Cancel</a>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection