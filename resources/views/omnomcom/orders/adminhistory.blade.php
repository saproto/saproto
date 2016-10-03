@extends('website.layouts.default-nobg')

@section('page-title')
    Orderline Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-9">

            @if(count($orderlines) > 0)

                <?php
                $current_date = date('d-m-Y', strtotime($orderlines[0]->created_at));
                ?>

                <div class="list-group">

                    <li class="list-group-item list-group-item-success">{{ date('l F jS', strtotime($current_date)) }}</li>

                    @foreach($orderlines as $orderline)

                        @if(date('d-m-Y', strtotime($orderline->created_at)) != $current_date)

                </div>
                <div class="list-group">

                    <?php $current_date = date('d-m-Y', strtotime($orderline->created_at)); ?>
                    <li class="list-group-item list-group-item-success">{{ date('l F jS', strtotime($current_date)) }}</li>

                    @endif

                    <li class="list-group-item">

                        <div class="row">

                            <div class="col-md-3">
                                @if($orderline->user)

                                    <a href="{{ route('user::profile', ['id' => $orderline->user->id]) }}">
                                        {{ $orderline->user->name }}
                                    </a>

                                @else

                                    No associated user account

                                @endif
                            </div>

                            <div class="col-md-3"
                                 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $orderline->units }}x <strong>{{ $orderline->product->name }}</strong>
                            </div>

                            <div class="col-md-2"
                                 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                @if($orderline->isPayed())
                                    @if($orderline->payed_with_withdrawal !== null)
                                        Withdrawal #{{ $orderline->payed_with_withdrawal }}
                                    @elseif($orderline->payed_with_cash !== null)
                                        Cash
                                    @elseif($orderline->payed_with_mollie !== null)
                                        Mollie #{{ $orderline->payed_with_mollie }}
                                    @endif
                                @else
                                    Unpaid
                                @endif
                            </div>

                            <div class="col-md-2" style="text-align: right;">
                                <strong>&euro;</strong> {{ number_format($orderline->total_price, 2, '.', '') }}
                            </div>

                            <div class="col-md-2" style="text-align: right; color: #aaa;">
                                {{ date('H:i:s', strtotime($orderline->created_at)) }}

                                <a class="btn btn-xs btn-{{ ($orderline->isPayed() ? 'default' : 'danger') }}"
                                   style="margin-left: 10px;"
                                   href="{{ ($orderline->isPayed() ? '#' : route('omnomcom::orders::delete', ['id' => $orderline->id])) }}"
                                   role="button" {{ ($orderline->isPayed() ? 'disabled' : '') }}>
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </div>

                        </div>

                    </li>

                    @endforeach

                </div>

            @else

                <div class="list-group">

                    <li class="list-group-item">
                        No orderlines for the specified date.
                    </li>

                </div>

            @endif

        </div>

        <div class="col-md-3">

            <form method="get" action="{{ route('omnomcom::orders::adminlist') }}">

                <div class="panel panel-default">

                    <div class="panel-heading" style="padding: 10px; text-align: center;">

                        Orderline History

                    </div>

                    <div class="panel-body">

                        <p style="text-align: center;">
                            @if(!$date)
                                Today's orderlines
                            @else
                                Orderlines of {{ $date }}
                            @endif
                        </p>

                        <hr>

                        <div class="form-group">
                            <label for="date">Orderlines from:</label>
                            <input type="text" class="form-control datetime-picker" id="date"
                                   name="date" value="{{ $date or '' }}"
                                   placeholder="{{ Carbon\Carbon::today()->format('Y-m-d') }}">
                        </div>

                    </div>

                    <div class="panel-footer clearfix">
                        <input type="submit" class="btn btn-success pull-right" value="Get orders">
                    </div>

                </div>

            </form>

            <div class="btn-group btn-group-justified" role="group">
                <a class="btn btn-success" data-toggle="modal" data-target="#orderlinemodal">Add orderlines manually</a>
            </div>

        </div>

    </div>

    <!-- Add order modal! //-->

    <div id="orderlinemodal" class="modal fade" tabindex="-1" role="dialog">

        <div class="modal-dialog modal-lg">

            <form method="post" action="{{ route('omnomcom::orders::addbulk') }}">

                {!! csrf_field() !!}

                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add orderlines</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row orderlinerow" style="margin-bottom:10px;">

                            <div class="col-md-3">

                                <select name="user[]" class="form-control orderlineuser">
                                    @foreach(Proto\Models\User::orderBy('name', 'asc')->get() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} (#{{ $user->id }})</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-3">

                                <select name="product[]" class="form-control orderlineproduct">
                                    @foreach(Proto\Models\Product::orderBy('name', 'asc')->get() as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}
                                            (&euro;{{ $product->price }}, #{{ $product->id }})
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-2">

                                <div class="input-group">
                                    <input type="number" name="units[]" value="1"
                                           class="orderlineunits form-control" required>
                                    <span class="input-group-addon">x</span>
                                </div>

                            </div>

                            <div class="col-md-2">

                                <div class="input-group">
                                    <span class="input-group-addon">&euro;</span>
                                    <input type="text" name="price[]" placeholder="Price"
                                           class="orderlineprice form-control">
                                </div>

                            </div>

                            <div class="col-md-2">

                                <button type="button" class="btn btn-danger orderlinedeleterow">Delete</button>

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button id="orderlineaddrow" type="button" class="btn btn-default pull-left">Add another row
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                next: "fa fa-chevron-right",
                previous: "fa fa-chevron-left"
            },
            format: 'YYYY-MM-DD'
        });

        $('#orderlineaddrow').click(function () {

            var oldrow = $('.orderlinerow').last();

            $('#orderlinemodal .modal-body').append(oldrow.wrap('<p/>').parent().html());
            oldrow.unwrap();

            $(".orderlineuser:eq(-1)").val($(".orderlineuser:eq(-2)").val());
            $(".orderlineproduct:eq(-1)").val($(".orderlineproduct:eq(-2)").val());
            $(".orderlineunits:eq(-1)").val($(".orderlineunits:eq(-2)").val());
            $(".orderlineprice:eq(-1)").val($(".orderlineprice:eq(-2)").val());
        });

        $('div').delegate('.orderlinedeleterow', 'click', function () {
            $(this).parents('.orderlinerow').remove();
        });

    </script>

@endsection