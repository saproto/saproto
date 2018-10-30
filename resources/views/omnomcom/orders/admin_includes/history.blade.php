<div class="card">

    <div class="card-header bg-dark text-white">
        Orderlines on {{ $date }}
    </div>

    @if(count($orderlines) > 0)

        <table class="table table-hover table-sm">

            <tbody>
            @foreach($orderlines as $orderline)

                <tr>
                    <td>
                        @if(!$orderline->isPayed())
                            <a href="{{ ($orderline->isPayed() ? '#' : route('omnomcom::orders::delete', ['id' => $orderline->id])) }}"
                               @if ($orderline->isPayed())
                               disabled
                               @else
                               onclick="javascript:return confirm('You are about to delete an orderline for {{  $orderline->user->name }}. Are you sure? ');"
                                    @endif
                            >
                                <i class="fas fa-trash ml-3 text-danger" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="fas fa-trash ml-3 text-muted" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-right">
                        &euro; {{ number_format($orderline->total_price, 2, '.', '') }}
                    </td>
                    <td>
                        <span class="text-muted mr-2">{{ $orderline->units }}x</span>
                        {{ $orderline->product->name }}
                    </td>
                    <td>
                        @if ($orderline->description)
                            <span class="text-muted"><em>{{ $orderline->description }}</em></span>
                        @endif
                    </td>
                    <td>
                        @if($orderline->user)
                            @if($orderline->user->isMember)
                                <a href="{{ route('user::profile', ['id' => $orderline->user->getPublicId()]) }}">
                                    {{ $orderline->user->name }}
                                </a>
                            @else
                                {{ $orderline->user->name }}
                            @endif
                        @elseif($orderline->cashier)
                            [Cashier: {{ $orderline->cashier->name }}]
                        @else
                            <em class="text-muted">Anonymised</em>
                        @endif
                    </td>
                    <td>{!! $orderline->generateHistoryStatus() !!}</td>
                    <td>{{ date('H:i:s', strtotime($orderline->created_at)) }}</td>
                </tr>

            @endforeach
            </tbody>

        </table>

        <div class="card-footer pb-0">
            {!! $orderlines->links() !!}
        </div>

    @else
        <div class="card-body">
            <p class="text-center mt-3">
                No orderlines for this date.
            </p>
        </div>
    @endif

</div>

