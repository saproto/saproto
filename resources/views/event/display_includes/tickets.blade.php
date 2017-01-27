@if($event->tickets()->count() > 0)

    @if(Auth::check() && count($event->getTicketPurchasesFor(Auth::user())) > 0)

        <div class="panel panel-default">

            <div class="panel-heading" style="text-align: center;">
                Your Tickets
            </div>

            <div class="panel-body" style="text-align: center;">

                @foreach($event->getTicketPurchasesFor(Auth::user()) as $i => $purchase)

                    @if($i % 2 == 0)
                        <div class="row">
                            @endif

                            <div class="col-md-6">

                                <div class="well"
                                     style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; ">
                                    <strong>{{ $purchase->ticket->product->name }}</strong>
                                    <br>
                                    <a href="{{ route("tickets::download", ['id'=>$purchase->id]) }}"
                                       style="text-decoration: none;">
                                        <span class="label label-success">
                                            Download PDF
                                        </span>
                                    </a>
                                    &nbsp;
                                    <span class="label label-default">#{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    &nbsp;
                                    <span class="label label-info">&euro;{{ number_format($purchase->orderline->total_price, 2) }}</span>

                                </div>

                            </div>

                            @if($i % 2 == 1 || $i + 1 == count($event->getTicketPurchasesFor(Auth::user())))
                        </div>
                    @endif

                @endforeach

            </div>

        </div>

    @endif

    <form method="post" action="{{ route('event::buytickets', ['id'=>$event->id]) }}">

        {!! csrf_field() !!}

        <div class="panel panel-default">

            <div class="panel-heading" style="text-align: center;">
                Event Tickets
            </div>

            <div class="panel-body" style="text-align: center;">

                <p>You need to buy tickets to attend this event. See below for the available tickets.</p>

                <hr>

                @if(!Auth::check())
                    <p>
                        Please <a href="{{ route('login::show') }}">log-in</a> to buy tickets.
                    </p>
                @elseif(!Auth::user()->bank)
                    <p>
                        You need to to have an active withdrawal authorization to buy tickets.<br>
                        Please <a href="{{ route('user::bank::add', ['id' => Auth::id()]) }}">authorize us for an
                            automatic withdrawal</a> to buy tickets.
                    </p>
                @else
                    <div class="form-horizontal">
                        @foreach($event->tickets as $ticket)
                            <div class="form-group"
                                 style="opacity: {{ ($ticket->isAvailable(Auth::user()) ? '1' : '0.5') }};">
                                <div class="col-md-2">
                                    @if($ticket->isAvailable(Auth::user()))
                                        <select required class="form-control ticket-select"
                                                name="tickets[{{$ticket->id}}]"
                                                data-price="{{ $ticket->product->price }}"
                                                onchange="updateOrderTotal();">
                                            @for($i = 0; $i <= min(config('proto.maxtickets'), $ticket->product->stock); $i++)
                                                <option value="{{ $i }}">{{ $i }}x</option>
                                            @endfor
                                        </select>
                                    @endif
                                </div>
                                <div class="col-md-8 control-label" style="text-align: left;">
                                    @if ($ticket->isAvailable(Auth::user()))
                                        <strong>{{ $ticket->product->name }}</strong>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $ticket->product->stock > config('proto.maxtickets') ? config('proto.maxtickets').'+' : $ticket->product->stock }}
                                        available
                                    @else
                                        {{ $ticket->product->name }}
                                    @endif
                                    <br>
                                    <sup>
                                        @if(date('U') > $ticket->available_to)
                                            Not for sale anymore.
                                        @elseif(date('U') < $ticket->available_from)
                                            For sale
                                            starting {{ date('d-m-Y H:i', $ticket->available_from) }}
                                        @elseif(!$ticket->canBeSoldTo(Auth::user()))
                                            This ticket is only available to members!
                                        @elseif($ticket->product->stock <= 0)
                                            Sold-out!
                                        @else
                                            <strong>On sale!</strong> Available
                                            until {{ date('d-m-Y H:i', $ticket->available_to) }}
                                        @endif
                                    </sup>
                                </div>
                                <div class="col-md-2 control-label" style="text-align: left;">
                                    <strong>&euro;{{ number_format($ticket->product->price, 2) }}</strong>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2 control-label" style="text-align: left;">
                                <strong>Order total:</strong>
                            </div>
                            <div class="col-md-2 control-label" style="text-align: left;">
                                &euro;<span id="ticket-total">0.00</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if(Auth::user()->bank)
                <div class="panel-footer">

                    <input type="submit" class="form-control btn btn-success" value="Purchase Tickets"
                           onclick="return confirm('You are about to buy €'+total.toFixed(2)+' worth of tickets. Are you sure?')">

                </div>
            @endif

        </div>

    </form>

@endif
<script type="text/javascript">

    var total = 0;
    function updateOrderTotal() {
        total = 0;
        $('.ticket-select').each(function () {
            total += $(this).attr('data-price') * $(this).val();
        });
        $('#ticket-total').html(total.toFixed(2))
    }

</script>
