<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Your orders:
    </div>

    <div class="table-responsive">

        <table class="table table-sm">

            <thead>
                <tr>
                    <th>description</th>
                    <th>price</th>
                    <th class="text-center">Helper</th>
                    @if($dinnerform->isCurrent())
                        <th>Controls</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach($previousOrders as $order)
                    <tr>
                        <td>{{$order->description}}</td>
                        <td>€{{$order->price}}</td>
                        <td class="text-center">
                            @if($order->helper)
                                <i class="fas fa-check text-info" aria-hidden="true"></i>
                            @endif
                        </td>
                        @if($dinnerform->isCurrent())
                            <td>
                                @include('website.layouts.macros.confirm-modal', [
                                            'action' => route("dinnerform::orderline::delete", ['id' => $order->id]),
                                            'text' => '<i class="fas fa-trash text-danger"></i>',
                                            'title' => 'Confirm Delete',
                                            'message' => "Are you sure you want to delete your order: $order->description at $dinnerform->restaurant?",
                                            'confirm' => 'Delete',
                                        ])
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>