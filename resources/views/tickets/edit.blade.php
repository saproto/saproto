@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($ticket == null ? "Create new ticket." : "Edit ticket " . $ticket->product->name .".") }}
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

                        <div class="form-group autocomplete">
                            <label for="product">Product:</label>
                            <input class="form-control product-search" id="product" name="product" placeholder="{{ $ticket ? $ticket->product->name : '' }}" value="{{ $ticket ? $ticket->product->id : '' }}" {{ $ticket ? '' : 'required' }}>
                        </div>

                        <div class="form-group autocomplete">
                            <label for="event">Event:</label>
                            <input class="form-control event-search" id="event" name="event" placeholder="{{ $ticket ? $ticket->event->title : '' }}" value="{{ $ticket ? $ticket->event->id : ''  }}" {{ $ticket ? '' : 'required' }}>
                        </div>

                        @include('website.layouts.macros.datetimepicker', [
                            'name' => 'available_from',
                            'label' => 'Available from:',
                            'placeholder' => $ticket ? $ticket->available_from : null
                        ])

                        @include('website.layouts.macros.datetimepicker', [
                            'name' => 'available_to',
                            'label' => 'Available to:',
                            'placeholder' => $ticket ? $ticket->available_to : null
                        ])

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

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="show_participants" {{ ($ticket && $ticket->show_participants ? 'checked' : '') }}>
                                Show the participant's who bought this ticket on the event.
                            </label>
                        </div>

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-end">Submit</button>

                        <a href="{{ route("tickets::list") }}" class="btn btn-default">Cancel</a>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection