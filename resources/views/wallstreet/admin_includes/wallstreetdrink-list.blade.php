<div class="card mb-3">

    <div class="card-header bg-dark text-white mb-1">
        WallstreetDrink overview
    </div>

    @if(count($allDrinks) > 0)
        <div class="table-responsive">

            <table class="table table-sm">

                <thead>
                    <tr class="bg-dark text-white">
                        <th></th>
                        <th>Restaurant</th>
                        <th>Event</th>
                        <th class="text-center">Status</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Total</th>
                        <th class="text-center">Admin</th>
                        <th class="text-center">Controls</th>
                    </tr>
                </thead>

                <tbody>
                        @foreach($allDrinks as $dinnerform)
                            <tr class="align-middle text-nowrap">
                                <td class="text-muted">#{{ $dinnerform->id }}</td>
                                <td>
                                    <a href="{{ route('dinnerform::show', ['id' => $dinnerform->id]) }}">
{{--                                        {{ $dinnerform->restaurant }}--}}
                                    </a>
                                </td>
                                <td>
                                    @isset($dinnerform->event)
                                        <a href="{{ route('event::show', ['id' => $dinnerform->event->getPublicId()]) }}">{{ $dinnerform->event->title}}</a>
                                    @endisset
                                </td>
                                <td>{{ $dinnerform->start_time->format('Y m-d H:i') }}</td>
                                <td>{{ $dinnerform->end_time->format('Y m-d H:i') }}</td>
                                <td>€{{ number_format($dinnerform->totalAmountWithDiscount(), 2) }}</td>
                                <td class="text-center px-4">
                                    <a class="btn btn-info badge" href="{{ route('dinnerform::admin', ['id' => $dinnerform->id]) }}">
                                        View orders
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="text-center text-muted py-3">
            There are no dinnerforms!
        </div>

    @endif

</div>

