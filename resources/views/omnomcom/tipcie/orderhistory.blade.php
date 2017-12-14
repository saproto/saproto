@extends('website.layouts.default-nobg')

@section('page-title')
    TIPCie Order History
@endsection

@section('content')

    <div class="row">

        <div class="col-md-3 col-md-push-9">

            <form method="get" action="{{ route('omnomcom::tipcie::orderhistory') }}">

                <div class="panel panel-default">

                    <div class="panel-heading" style="padding: 10px; text-align: center;">

                        TIPCie Orderline History

                    </div>

                    <div class="panel-body">

                        <p style="text-align: center;">
                            @if(!$date)
                                Today's orders
                            @else
                                Orderlines of {{ $date }}
                            @endif

                            <br />

                            <i>A day starts at 6am</i>
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

        </div>

        <div class="col-md-9 col-md-pull-3">

            <div class="panel panel-default">

                <div class="panel-body">

                    @if(count($orders) > 0)
                        <table class="table">
                            <tr>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Total</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->amount }}</td>
                                    <td>&euro; {{ number_format($order->totalPrice, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong>{{ $dailyAmount }}</strong></td>
                                <td><strong>&euro; {{ number_format($dailyTotal, 2) }}</strong></td>
                            </tr>
                        </table>
                    @else

                        <p>No orders for the specified date.</p>

                    @endif

                </div>

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
                                    @foreach(Proto\Models\User::orderBy('name', 'asc')->has('member')->get() as $user)
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