@extends('website.layouts.redesign.generic')

@section('page-title')
    Dinner Form Admin
@endsection
@section('container')
    <div class="card mb-3">

        <div class="card-header bg-dark text-white mb-1">
            <span>Dinnerform orderline overview</span>
            @if($dinnerform->isCurrent())
                @include('website.layouts.macros.confirm-modal', [
                    'action' => route("dinnerform::close", ['id' => $dinnerform->id]),
                    'text' => '<i class="fas fa-ban"></i> Close dinnerform!',
                    'title' => 'Confirm Close',
                    'message' => "Are you sure you want to close the dinnerform for $dinnerform->restaurant early? The dinnerform will close automatically at $dinnerform->end.",
                    'confirm' => 'Close',
                    'classes' => 'btn btn-warning badge float-end'
                ])
            @elseif(!$dinnerform->closed)
                @include('website.layouts.macros.confirm-modal', [
                         'action' => route("dinnerform::process", ['id' => $dinnerform->id]),
                         'text' => '<i class="fas fa-file-export"></i> Process dinnerform',
                         'title' => 'Confirm processing dinnerform',
                         'message' => "Are you sure you want to process the dinnerform from $dinnerform->restaurant?<br> This will convert all dinnerform orderlines to orderlines and mean none of the orderlines can be changed anymore!",
                         'confirm' => 'Process',
                         'classes'=>"btn btn-danger badge float-end"
                    ])
            @else
                <span class="bg-info badge float-end">
                    <i class="fas fa-check"></i> Processed!
                </span>
            @endif
        </div>

        <div class="table-responsive">

            <table class="table table-sm">

                <thead>
                    <tr class="bg-dark text-white">
                        <td>Total</td>
                        <td>Orders</td>
                        <td>Helpers</td>
                        <td>Helper discount</td>
                        <td>Total with helper discount</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="align-middle">€{{ $dinnerform->totalAmount() }}</td>
                        <td class="align-middle">{{ $dinnerform->orderCount() }}</td>
                        <td class="align-middle">{{ $dinnerform->helperCount() }}</td>
                        <td class="align-middle">€{{ $dinnerform->discount }}</td>
                        <td class="align-middle">€{{ $dinnerform->totalAmountwithHelperDiscount() }}</td>
                    </tr>
                </tbody>

                <thead>
                    <tr class="bg-dark text-white">
                        <td>User</td>
                        <td>Order</td>
                        <td>Price</td>
                        <td>Helper</td>
                        <td>Price with discount</td>
                        <td>Controls</td>
                        <td></td>
                    </tr>
                </thead>

                <tbody>
                    @if(count($orderList) > 0)
                        @foreach($orderList as $order)
                            <tr>
                                <td class="align-middle">{{ $order->user()->name }}
                                    <span class="text-muted"> {{ $order->user()->id }}</span>
                                </td>
                                <td class="align-middle">{{ $order->description }}</td>
                                <td class="align-middle"> €{{ $order->price }} </td>
                                <td class="align-middle">
                                    @if($order->helper)
                                     <i class="fas fa-check text-info" aria-hidden="true"></i>
                                    @endif
                                </td>
                                <td>
                                    €{{$order->price}}
                                </td>
                                <td class="text-start align-middle">
                                    @if(!$order->closed)
                                    <a href="{{ route('dinnerform::orderline::edit', ['id' => $order->id]) }}">
                                        <i class="fas fa-edit me-2"></i>
                                    </a>
                                    @include('website.layouts.macros.confirm-modal', [
                                        'action' => route("dinnerform::orderline::delete", ['id' => $order->id]),
                                        'text' => '<i class="fas fa-trash text-danger"></i>',
                                        'title' => 'Confirm Delete',
                                        'message' => "Are you sure you want to remove the dinnerform opening $dinnerform->start ordering at $dinnerform->restaurant?",
                                        'confirm' => 'Delete',

                                    ])
                                    @endif
                                </td>
                            </tr>
                      @endforeach
                @else
                    <tr>
                        <td>There are no orderlines yet!</td>
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
@endsection
