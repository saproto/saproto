@if($event->tickets()->count() > 0)

    <?php $has_unpaid_tickets = false; ?>

    @if(count($event->getTicketPurchasesFor(Auth::user())) > 0)

        <div class="card mb-3">

            <div class="card-header ellipsis">
                Your tickets for {{ $event->title }}
            </div>

            <div class="card-body">

                @foreach($event->getTicketPurchasesFor(Auth::user()) as $i => $purchase)

                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-title">
                                <span class="badge badge-dark text-white float-right">
                                    #{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                                <strong>{{ $purchase->ticket->product->name }}</strong>
                                (&euro;{{ number_format($purchase->orderline->total_price, 2) }})
                            </p>

                            @if($purchase->canBeDownloaded())
                                <a href="{{ route("tickets::download", ['id'=>$purchase->id]) }}"
                                   class="card-link text-primary">
                                    Download PDF
                                </a>
                            @else
                                <?php $has_unpaid_tickets = true; ?>
                                <a class="card-link text-danger"
                                   href="{{ $purchase->orderline->molliePayment->payment_url or route("omnomcom::orders::list") }}">
                                    Payment Required
                                </a>
                            @endif

                        </div>
                    </div>

                @endforeach

            </div>

            @if($has_unpaid_tickets)
                <div class="card-footer text-center">
                    <strong class="text-danger"><i class="fas fa-exclamation-triangle fa-fw mr-2"></i> Attention!</strong><br>
                    You have unpaid tickets. You need to pay for your tickets before you can download and use them.
                    Unpaid tickets will be invalidated if payment takes too long.
                </div>
            @endif

        </div>

    @endif

    <form method="post" action="{{ route('event::buytickets', ['id'=>$event->id]) }}">

        {!! csrf_field() !!}

        <div class="card mb-3">

            <?php $has_prepay_tickets = false; ?>
            <?php $tickets_available = 0; ?>

            <div class="card-header ellipsis">
                Buy tickets for {{ $event->title }}
            </div>

            <div class="card-body">

                @if(!Auth::check())

                    <p class="card-text">
                        Please <a href="{{ route('event::login', ['id' => $event->getPublicId()]) }}">log-in</a> to buy
                        tickets.
                    </p>

                @else

                    @foreach($event->tickets as $ticket)

                        <div class="card mb-3"
                             style="opacity: {{ ($ticket->isAvailable(Auth::user()) ? '1' : '0.5') }};">

                            <div class="card-body">

                                <p class="card-title">

                                    @if ($ticket->is_prepaid)
                                        <?php $has_prepay_tickets = true; ?>
                                        <span class="badge badge-danger float-right">Pre-Paid</span>
                                    @else
                                        <span class="badge badge-primary float-right">Withdrawal</span>
                                    @endif

                                    <strong>{{ $ticket->product->name }}</strong>
                                    (&euro;{{ number_format($ticket->product->price, 2) }})

                                </p>

                                <p class="card-text">

                                    @if ($ticket->isAvailable(Auth::user()))
                                        <span class="badge badge-info float-right">
                                    {{ $ticket->product->stock > config('proto.maxtickets') ? config('proto.maxtickets').'+' : $ticket->product->stock }}
                                            available
                                    </span>
                                    @endif

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
                                        <?php $tickets_available++; ?>
                                        <strong>On sale!</strong><br>
                                        Available until {{ date('d-m-Y H:i', $ticket->available_to) }}
                                    @endif

                                </p>

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
                        </div>

                    @endforeach

                @endif

            </div>

            @if(Auth::check() && $tickets_available > 0)
            <div class="card-footer">

                <button type="submit" class="btn btn-success btn-block"
                       onclick="return confirm('You are about to buy €'+total.toFixed(2)+' worth of tickets. Are you sure?')">
                    Total: <strong>&euro;<span id="ticket-total" class="mr-3">0.00</span></strong> Finish purchase!
                </button>

            </div>
            @endif

        </div>

    </form>

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

@endif