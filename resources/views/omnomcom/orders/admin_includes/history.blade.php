<div class="card">

    <div class="card-header bg-dark text-white">
        Orderlines on {{ $date }}
    </div>

    @if(count($orderlines) > 0)

        <div class="table-responsive">
        <table class="table table-hover table-sm">

            <tbody>
            @foreach($orderlines as $orderline)

                <tr>
                    <td>
                        <span class="text-muted">{{ $orderline->id }}</span>
                        @if($orderline->canBeDeleted())
                            <a href="{{ route('omnomcom::orders::delete', ['id' => $orderline->id]) }}"
                               onclick="return confirm('You are about to delete an orderline for {{  $orderline->user->name }}. Are you sure? ');">
                                <i class="fas fa-trash ms-3 text-danger" aria-hidden="true"></i>
                            </a>
                        @endif
                    </td>
                    <td class="text-end" style="min-width:70px">
                        &euro; {{ number_format($orderline->total_price, 2, '.', '') }}
                    </td>
                    <td>
                        <span class="text-muted me-2">{{ $orderline->units }}x</span>
                    </td>
                    <td style="min-width:150px">
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
                    <td class="text-muted">{{ $orderline->authenticated_by }}</td>
                    <td>{{ date('H:i:s', strtotime($orderline->created_at)) }}</td>
                </tr>

            @endforeach
            </tbody>

        </table>
        </div>

        @if(method_exists($orderlines, 'links'))
            <div class="card-footer pb-0">
                {!! $orderlines->links() !!}
            </div>
        @endif

    @else
        <div class="card-body">
            <p class="text-center mt-3">
                No orderlines for this date.
            </p>
        </div>
    @endif

</div>

