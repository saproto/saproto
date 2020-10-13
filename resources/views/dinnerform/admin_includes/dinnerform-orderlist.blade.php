<div class="card mb-3">

    <div class="card-header bg-dark text-white mb-1">
        Dinnerform overview Orders
    </div>

    <table class="table table-sm">

        <thead>

        <tr class="bg-dark text-white">

            <td>Member ID</td>
            <td>Price</td>
            <td></td>
        </tr>

        </thead>
        <tbody>

        @if(count($orders) > 0)
            @foreach($orders as $order)
                <tr>
                    <td class="align-middle">{{ $order->id }} <span class="text-muted">(#{{ $order->id }})</span></td>
                    <td class="align-middle">{{$order->price}}<span class="text-muted">(#{{$order->price}}</span></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>There are no dinnerforms available.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif

        </tbody>

    </table>
</div>