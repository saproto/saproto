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

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fas fa-clock-o",
                date: "fas fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down",
                next: "fas fa-chevron-right",
                previous: "fas fa-chevron-left"
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