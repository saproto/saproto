@extends('website.layouts.default')

@section('page-title')
    Event Admin
@endsection

@section('content')

    <p style="text-align: center;">
        <a href="{{ route("event::checklist", ['id' => $event->id]) }}">Participant Checklist</a>
    </p>

    @if(Auth::user()->can('board'))
        <p style="text-align: center;">
            <strong>Contact details</strong>
        </p>
        <p style="text-align: center;">
            Please remember to always use the BCC field (not the to or CC field) when sending emails to participants!
        </p>
        <textarea class="form-control">{{ implode(',', $event->getAllEmails()) }}</textarea>
    @endif


    <hr>

    @if ($event->shouldShowDietInfo())

        <p style="text-align: center;">
            Diet and alergy information for Event.
        </p>

        <table class="table">
            <thead>
            <tr>
                <th>User</th>
                <th>Diet and Allergy Info</th>
            </tr>
            </thead>
            <tbody>

            @foreach($event->returnAllUsers() as $user)

                @if($user->hasDiet())

                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{!! $user->renderDiet() !!}</td>
                    </tr>

                @endif

            @endforeach

            </tbody>
        </table>

    @else

        <p style="text-align: center;">
            There is no diet and allergy information available for this event.
        </p>

    @endif

    <hr>

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
                                @if($event->shouldShowDietInfo())
                                    <th>Diet</th>
                                @endif
                                <th class="dontprint">Price</th>
                                <th class="dontprint">Date of Purchase</th>
                                <th>Ticket Scanned</th>
                                @if (Auth::user()->can('board'))
                                    <th class="dontprint">Delete Ticket</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ticket->purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>
                                        {{ $purchase->user->name }}
                                        @if($purchase->user->age() >= 18)
                                            <span class="label label-success">
                                                <i class="fa fa-check" aria-hidden="true"></i> 18+
                                            </span>
                                        @else
                                            <span class="label label-danger">
                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 18-
                                            </span>
                                        @endif
                                    </td>
                                    @if($event->shouldShowDietInfo())
                                        <td>
                                            @if ($purchase->user->hasDiet())
                                                <span class="label label-danger">
                                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> yes
                                                </span>
                                            @else
                                                <span class="label label-success">
                                                    <i class="fa fa-check" aria-hidden="true"></i> no
                                                </span>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="dontprint">
                                        &euro;{{ number_format($purchase->orderline->total_price, 2) }}</td>
                                    <td class="dontprint">{{ $purchase->created_at }}</td>
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
                                    @if (Auth::user()->can('board'))
                                        <td class="dontprint">
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

@section('javascript')

    @parent

    <script>

        $(".events__scannedButton").click(function (event) {
            event.preventDefault();
            var barcode = $(this).attr('data-id');
            var parent = $(this).parent();
            if (barcode === undefined) throw new Error("Can\'t find barcode");
            $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});
            $.ajax({
                type: "GET",
                url: '{!! route('api::scan', ['event' => $event->id]) !!}',
                data: {'barcode': barcode},
                success: function () {
                    console.log('Scanned barcode ' + barcode);
                    parent.html(new Date().toISOString().substring(0, 19).replace('T', ' ') + " / <a href='{{ route('tickets::unscan', ['barcode' => '']) }}/" + barcode + "'>Unscan</a>");
                },
                error: function () {
                    window.alert('Couldn\'t register scan.');
                }
            });
        });

    </script>

@endsection

@section('stylesheet')
    @parent
    <style type="text/css">
        @media print {
            a[href]:after {
                content: none !important;
            }

            #footer, #header, p, textarea, hr, .dontprint {
                display: none !important;
            }
        }
    </style>
@endsection