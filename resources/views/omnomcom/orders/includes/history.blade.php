<div class="card">

    <div class="card-header bg-dark text-white">
        @yield('page-title')
    </div>

    <div class="card-body">

        @if(count($orderlines) > 0)

            <table class="table table-borderless table-hover table-sm">

                <?php $current_date = null; ?>

                @foreach($orderlines as $orderline)

                    @if(date('d-m-Y', strtotime($orderline->created_at)) != $current_date)
                        <?php $current_date = date('d-m-Y', strtotime($orderline->created_at)); ?>
                        <tr class="bg-dark text-white">
                            <td colspan="4">
                                <span class="ml-3">
                                    <i class="fas fa-calendar-alt fa-fw mr-3"></i>
                                    {{ date('l F jS', strtotime($current_date)) }}
                                </span>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td>
                            <strong>&euro;</strong> {{ number_format($orderline->total_price, 2, '.', '') }}
                        </td>
                        <td>
                            {{ $orderline->units }}x <strong>{{ $orderline->product->name }}</strong>
                            @if ($orderline->description)
                                <br><span class="text-muted"><em>{{ $orderline->description }}</em></span>
                            @endif
                        </td>
                        <td>{!! $orderline->generateHistoryStatus() !!}</td>
                        <td>{{ date('H:i:s', strtotime($orderline->created_at)) }}</td>
                    </tr>

                @endforeach

            </table>

        @else

            <p class="card-text text-center">
                You didn't buy anything in this month.
            </p>

        @endif

    </div>

</div>