<div class="card mb-3">
    <div class="card-header bg-dark text-white">
        @yield('page-title')
    </div>

    @isset($orderlines)
        <table class="table-borderless table-hover table-sm mt-1 table">
            <?php $current_date = null; ?>

            @foreach ($orderlines as $orderline)
                @if (date('d-m-Y', strtotime($orderline->created_at)) != $current_date)
                    <?php $current_date = \Illuminate\Support\Carbon::parse(
                        $orderline->created_at,
                    )->format('d-m-Y'); ?>

                    <tr class="bg-dark mt-3 text-white">
                        <td class="text-end">
                            <i class="fas fa-calendar-alt"></i>
                        </td>
                        <td colspan="3">
                            {{ date('l, F jS', strtotime($current_date)) }}
                        </td>
                    </tr>
                @endif

                <tr>
                    <td class="text-end">
                        &euro;
                        {{ number_format($orderline->total_price, 2, '.', '') }}
                    </td>
                    <td>
                        <span class="text-muted me-2">
                            {{ $orderline->units }}x
                        </span>
                        {{ $orderline->product->name }}
                        @if ($orderline->description)
                            <br />
                            <span class="text-muted">
                                <em>{{ $orderline->description }}</em>
                            </span>
                        @endif
                    </td>
                    <td width="80" class="text-right">
                        {!! $orderline->generateHistoryStatus() !!}
                    </td>
                    <td class="pl-4">
                        {{ date('H:i:s', strtotime($orderline->created_at)) }}
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="card-body">
            <p class="card-text text-center">
                You didn't buy anything in this month.
            </p>
        </div>
    @endif
</div>
