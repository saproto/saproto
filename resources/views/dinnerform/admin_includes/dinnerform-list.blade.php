<div class="card mb-3">
    <div class="card-header bg-dark mb-1 text-white">Dinnerform overview</div>

    @if (count($dinnerformList) > 0)
        <div class="table-responsive">
            <table class="table-sm table">
                <thead>
                    <tr class="bg-dark text-white">
                        <th></th>
                        <th>Restaurant</th>
                        <th>Event</th>
                        <th class="text-center">Status</th>
                        <th>Start</th>
                        <th>Total</th>
                        <th class="text-center text-nowrap">Ordered by</th>
                        <th class="text-center">Admin</th>
                        <th class="text-center">Controls</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($dinnerformList as $dinnerform)
                        <tr class="align-middle text-nowrap">
                            <td class="text-muted">#{{ $dinnerform->id }}</td>
                            <td>
                                <a
                                    href="{{ route('dinnerform::show', ['id' => $dinnerform->id]) }}"
                                >
                                    {{ $dinnerform->restaurant }}
                                </a>
                            </td>
                            <td>
                                @isset($dinnerform->event)
                                    <a
                                        href="{{ route('event::show', ['event' => $dinnerform->event]) }}"
                                    >
                                        {{ \Illuminate\Support\Str::limit($dinnerform->event->title, 15) }}
                                    </a>
                                @endisset
                            </td>
                            <td class="text-center">
                                @if ($dinnerform->isCurrent())
                                    <i
                                        class="far fa-clock text-success"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Open"
                                    ></i>
                                @elseif ($dinnerform->closed)
                                    <i
                                        class="fas fa-check text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Processed"
                                    ></i>
                                @else
                                    <i
                                        class="fas fa-ban text-warning"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Closed"
                                    ></i>
                                @endif
                            </td>
                            <td>
                                {{ $dinnerform->start->format('Y m-d H:i') }}
                            </td>
                            <td>
                                €{{ number_format($dinnerform->totalAmountWithDiscount(), 2) }}
                            </td>
                            <td class="px-4 text-center">
                                @if ($dinnerform->orderedBy)
                                    <a
                                        class="btn btn-info badge"
                                        href="{{ route('user::profile', ['id' => $dinnerform->orderedBy->getPublicId()]) }}"
                                    >
                                        {{ $dinnerform->orderedBy->name }}
                                    </a>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                <a
                                    class="btn btn-info badge"
                                    href="{{ route('dinnerform::admin', ['id' => $dinnerform->id]) }}"
                                >
                                    Orders
                                </a>
                            </td>
                            <td class="text-center">
                                @if (! $dinnerform->closed)
                                    @if ($dinnerform->isCurrent())
                                        @include(
                                            'components.modals.confirm-modal',
                                            [
                                                'action' => route('dinnerform::close', ['id' => $dinnerform->id]),
                                                'text' => '<i class="fas fa-ban text-warning me-4"></i>',
                                                'title' => 'Confirm Close',
                                                'message' => "Are you sure you want to close the dinnerform for $dinnerform->restaurant early? The dinnerform will close automatically at $dinnerform->end.",
                                                'confirm' => 'Close',
                                            ]
                                        )
                                    @endif

                                    <a
                                        href="{{ route('dinnerform::edit', ['id' => $dinnerform->id]) }}"
                                    >
                                        <i class="fas fa-edit me-4"></i>
                                    </a>
                                    @include(
                                        'components.modals.confirm-modal',
                                        [
                                            'action' => route('dinnerform::delete', ['id' => $dinnerform->id]),
                                            'text' => '<i class="fas fa-trash text-danger"></i>',
                                            'title' => 'Confirm Delete',
                                            'message' => "Are you sure you want to remove the dinnerform opening $dinnerform->start ordering at $dinnerform->restaurant?<br><br> This will also delete all orderlines!",
                                            'confirm' => 'Delete',
                                        ]
                                    )
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-muted py-3 text-center">There are no dinnerforms!</div>
    @endif

    <div class="card-footer pb-0">{{ $dinnerformList->links() }}</div>
</div>
