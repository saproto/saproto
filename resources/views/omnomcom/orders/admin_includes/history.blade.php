<div class="card">
    <div class="card-header bg-dark text-white">
        Orderlines
        @if ($user)
            for {{ $user }}
        @endif

        @if ($date)
                on {{ $date->format('Y-m-d') }}
        @endif

        @if (! $products->isEmpty())
            for product(s)
            @foreach ($products as $product)
                {{ $product }};
            @endforeach
        @endif
    </div>

    @if (count($orderlines) > 0)
        <div class="table-responsive">
            <table class="table-hover table-sm table">
                <tbody>
                    @foreach ($orderlines as $orderline)
                        <tr>
                            <td>
                                <span class="text-muted">
                                    {{ $orderline->id }}
                                </span>
                                @if ($orderline->canBeDeleted())
                                    @include(
                                        'components.modals.confirm-modal',
                                        [
                                            'action' => route('omnomcom::orders::delete', ['id' => $orderline->id]),
                                            'text' => '<i class="fas fa-trash text-danger ms-3"></i>',
                                            'title' => 'Confirm Delete',
                                            'message' =>
                                                'Are you sure you want to delete this orderline for ' .
                                                $orderline->user->name .
                                                '?',
                                            'confirm' => 'Delete',
                                        ]
                                    )
                                @endif
                            </td>
                            <td class="text-end" style="min-width: 70px">
                                &euro;
                                {{ number_format($orderline->total_price, 2, '.', '') }}
                            </td>
                            <td>
                                <span class="text-muted me-2">
                                    {{ $orderline->units }}x
                                </span>
                            </td>
                            <td style="min-width: 150px">
                                {{ $orderline->product->name }}
                            </td>
                            <td>
                                @if ($orderline->description)
                                    <span class="text-muted">
                                        <em>{{ $orderline->description }}</em>
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($orderline->user)
                                    @if ($orderline->user->isMember)
                                        <a
                                            href="{{ route('user::profile', ['id' => $orderline->user->getPublicId()]) }}"
                                        >
                                            {{ $orderline->user->name }}
                                        </a>
                                    @else
                                        {{ $orderline->user->name }}
                                    @endif
                                @elseif ($orderline->cashier)
                                    [Cashier: {{ $orderline->cashier->name }}]
                                @else
                                    <em class="text-muted">Anonymised</em>
                                @endif
                            </td>
                            <td>
                                {!! $orderline->generateHistoryStatus() !!}
                            </td>
                            <td class="text-muted">
                                {{ $orderline->authenticated_by }}
                            </td>
                            <td>
                                {{ date('d/m/Y H:i:s', strtotime($orderline->created_at)) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (method_exists($orderlines, 'links'))
            <div class="card-footer pb-0">
                {!! $orderlines->links() !!}
            </div>
        @endif
    @else
        <div class="card-body">
            <p class="mt-3 text-center">
                No orderlines for this {{ $date ? 'date' : 'user' }}.
            </p>
        </div>
    @endif
</div>
