@extends('website.layouts.redesign.generic')

@section('page-title')
    Event Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <a href="{{ route("event::checklist", ['id' => $event->id]) }}" class="btn btn-success btn-block mb-3">
                Participant Checklist
            </a>

            @if ($event->shouldShowDietInfo())

                <div class="card">

                    <div class="card-header bg-dark text-white">
                        Diet and allergy information.
                    </div>

                    <div class="card-body">

                        <table class="table">
                            <tbody>

                            @foreach($event->returnAllUsers() as $user)

                                @if($user->hasDiet())

                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{!! Markdown::convertToHtml($user->diet) !!}</td>
                                    </tr>

                                @endif

                            @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>

            @endif

        </div>

        @if (count($event->tickets) > 0)

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header bg-dark text-white">
                        Event tickets
                    </div>

                    <div class="card-body">

                        <a class="btn btn-success btn-block" href="{{ route('event::scan', ['id' => $event->id]) }}">
                            Start Scanner Application for Event
                        </a>

                        <hr>

                        @foreach($event->tickets as $ticket)

                            <div class="card mb-3">

                                <div class="card-header bg-dark text-white" style="cursor: pointer;"
                                     data-bs-toggle="collapse" data-bs-target="#ticket__collapse__{{ $ticket->id }}">
                                    Ticket <strong>{{ $ticket->product->name }}</strong>
                                    <span class="badge badge-primary float-end">
                                        {{ $ticket->sold() }} sold / {{ $ticket->product->stock }} available
                                    </span>
                                    <span class="badge badge-info float-end me-4">
                                        &euro;{{ number_format($ticket->turnover(), 2) }}
                                    </span>
                                </div>

                                <div class="collapse" id="ticket__collapse__{{ $ticket->id }}">

                                    <div class="card-body">

                                        @if ($ticket->purchases->count() > 0)

                                            <table class="table">

                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>User</th>
                                                    <th></th>
                                                    @if($event->shouldShowDietInfo())
                                                        <th>Diet</th>
                                                    @endif
                                                    <th>Price</th>
                                                    <th>Date of Purchase</th>
                                                    <th>Ticket Scanned</th>
                                                    @can('board')
                                                        <th></th>
                                                    @endcan
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($ticket->purchases as $purchase)
                                                    <tr>
                                                        <td>{{ $purchase->id }}</td>
                                                        <td>{{ $purchase->user->name }}</td>
                                                        <td>
                                                            @if($purchase->user->age() >= 18)
                                                                <span class="badge badge-success">
                                                                <i class="fas fa-check" aria-hidden="true"></i> 18+
                                                            </span>
                                                            @else
                                                                <span class="badge badge-danger">
                                                                <i class="fas fa-exclamation-triangle"
                                                                   aria-hidden="true"></i> 18-
                                                            </span>
                                                            @endif
                                                        </td>
                                                        @if($event->shouldShowDietInfo())
                                                            <td>
                                                                @if ($purchase->user->hasDiet())
                                                                    <span class="badge badge-danger">
                                                                    <i class="fas fa-exclamation-triangle"
                                                                       aria-hidden="true"></i>
                                                                </span>
                                                                @else
                                                                    <span class="label label-success">
                                                                    <i class="badge badge-check" aria-hidden="true"></i>
                                                                </span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        <td>
                                                            &euro;{{ number_format($purchase->orderline->total_price, 2) }}</td>
                                                        <td>{{ $purchase->created_at }}</td>
                                                        <td class="events__scanned">
                                                            @if ($purchase->scanned === null)
                                                                <a data-id="{{ $purchase->barcode }}"
                                                                   class="events__scannedButton dontprint" href="#">
                                                                    Scan Manually
                                                                </a>
                                                            @else
                                                                {{ $purchase->scanned }} /
                                                                <a href="{{ route('tickets::unscan', ['barcode' => $purchase->barcode]) }}">
                                                                    Unscan
                                                                </a>
                                                            @endif
                                                        </td>
                                                        @can('board')
                                                            <td class="dontprint">
                                                                @if($purchase->scanned)
                                                                    Used
                                                                @elseif($purchase->orderline->isPayed())
                                                                    Paid
                                                                @else
                                                                    <a class="badge badge-danger"
                                                                       href="{{ route('omnomcom::orders::delete', ['id'=>$purchase->orderline->id]) }}"
                                                                       onclick="return confirm('Are you sure you want to delete on ticket for {{ $purchase->user->name }}?')">
                                                                        Delete
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        @endcan
                                                    </tr>
                                                @endforeach
                                                </tbody>

                                            </table>

                                        @else

                                            <p class="card-text text-center">
                                                This ticket has not sold yet.
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        @endif

    </div>

@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">

        $(".events__scannedButton").on('click', function (event) {
            event.preventDefault();
            var barcode = $(this).attr('data-id');
            var parent = $(this).parent();
            if (barcode === undefined) throw new Error("Can\'t find barcode");
            $.ajax({
                type: "GET",
                url: '{!! route('api::scan', ['event' => $event->id]) !!}',
                data: {'barcode': barcode},
                success: function () {
                    console.log('Scanned barcode ' + barcode);
                    parent.html(new Date().toISOString().substring(0, 19).replace('T', ' ') + " / <a href='{{ route('tickets::unscan') }}/" + barcode + "'>Unscan</a>");
                },
                error: function () {
                    window.alert('Couldn\'t register scan.');
                }
            });
        });

    </script>

@endpush