@if($event->tickets()->count() > 0)

    @if(Auth::check() && count($event->getTicketPurchasesFor(Auth::user())) > 0)

        <?php $has_unpaid_tickets = false; ?>

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
                                    @if($purchase->canBeDownloaded())
                                        <a href="{{ route("tickets::download", ['id'=>$purchase->id]) }}"
                                           style="text-decoration: none;">
                                        <span class="label label-success">
                                            Download PDF
                                        </span>
                                        </a>
                                    @else
                                        <?php $has_unpaid_tickets = true; ?>
                                        <a href="{{ $purchase->orderline->molliePayment->payment_url or route("omnomcom::orders::list") }}"
                                           style="text-decoration: none;">
                                            <span class="label label-danger">Payment Required</span>
                                        </a>
                                    @endif
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

            @if($has_unpaid_tickets)
                <div class="panel-footer">

                    <p style="text-align: center">
                        You have unpaid tickets. You need to pay for your tickets before you can download and use them.
                        Unpaid tickets will be removed and invalidated after the payment opportunity has expired.
                    </p>

                </div>
            @endif

        </div>

    @endif

    <?php $has_prepay_tickets = false; ?>

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
                @else
                    <div class="form-horizontal">
                        <?php $tickets_available = 0; ?>
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
                                            <? $tickets_available++; ?>
                                            <strong>On sale!</strong> Available
                                            until {{ date('d-m-Y H:i', $ticket->available_to) }}
                                        @endif
                                    </sup>
                                </div>
                                <div class="col-md-2 control-label" style="text-align: left;">
                                    <strong>&euro;{{ number_format($ticket->product->price, 2) }}</strong>
                                    <br>
                                    @if ($ticket->is_prepaid)
                                        <?php $has_prepay_tickets = true; ?>
                                        <span class="label label-danger">Pre-Paid</span>
                                    @else
                                        <span class="label label-success">OmNomCom</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        @if ($tickets_available > 0)
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2 control-label" style="text-align: left;">
                                    <strong>Order total:</strong>
                                </div>
                                <div class="col-md-2 control-label" style="text-align: left;">
                                    &euro;<span id="ticket-total">0.00</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @if(Auth::check() && $tickets_available > 0)
                <div class="panel-footer">

                    <input type="submit" class="form-control btn btn-success" value="Purchase Tickets"
                           onclick="return confirm('You are about to buy €'+total.toFixed(2)+' worth of tickets. Are you sure?')">

                    @if($has_prepay_tickets)
                        <hr>
                        <p style="text-align: center">
                            If you buy one or more <span class="label label-danger">Pre-Paid</span> tickets you will need
                            to
                            pay for them immediately using our digital payment system. We accept multiple providers
                            including iDeal, Credit Card and BitCoin. If you cancel your payment half-way any <span
                                    class="label label-success">OmNomCom</span> tickets will still be ordered! <span
                                    class="label label-success">OmNomCom</span> tickets are paid via automatic
                            withdrawal, just like your other purhcases.
                        </p>
                    @endif

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
