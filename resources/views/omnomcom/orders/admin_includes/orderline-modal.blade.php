<!-- Add order modal! //-->

<div id="orderlinemodal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">

        <form method="post" action="{{ route('omnomcom::orders::addbulk') }}">

            {!! csrf_field() !!}

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add orderlines</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row orderlinerow">

                        <div class="col-md-3">

                            <select name="user[]" class="form-control orderlineuser">
                                @foreach(Proto\Models\User::orderBy('name', 'asc')->has('member')->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} (#{{ $user->id }})</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-3">

                            <select name="product[]" class="form-control orderlineproduct">
                                @foreach(Proto\Models\Product::where('is_visible', true)->orderBy('name', 'asc')->get() as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}
                                        (&euro;{{ $product->price }}, #{{ $product->id }})
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-2">

                            <div class="input-group mb-3">
                                <input type="number" class="form-control orderlineunits" name="units[]" value="1">
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-2">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">&euro;</span>
                                </div>
                                <input type="number" step="0.01" class="form-control orderlineprice" name="price[]"
                                       placeholder="0.00">
                            </div>

                        </div>

                        <div class="col-md-2">

                            <button type="button" class="btn btn-danger orderlinedeleterow" style="width: 100%;">
                                <i class="fas fa-minus-circle"></i>
                            </button>

                        </div>

                    </div>

                </div>

                <div class="card-footer border-bottom">
                    <div class="row">
                        <div class="col-md-2 offset-md-8 text-right">Total price:</div>
                        <div class="col-md-2" id="totalprice">&euro; 0.00</div>
                    </div>
                </div>

                <div class="modal-footer">

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="description"
                               placeholder="Optional additional information.">
                    </div>
                    <div class="col-2">
                        <button id="orderlineaddrow" class="btn btn-outline-success btn-block">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-outline-default btn-block" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

@push('javascript')

    <script type="text/javascript">

        $('#orderlineaddrow').click(function (e) {
            e.preventDefault();

            var oldrow = $('.orderlinerow').last();

            $('#orderlinemodal .modal-body').append(oldrow.wrap('<p/>').parent().html());
            oldrow.unwrap();

            $(".orderlineuser:eq(-1)").val($(".orderlineuser:eq(-2)").val());
            $(".orderlineproduct:eq(-1)").val($(".orderlineproduct:eq(-2)").val());
            $(".orderlineunits:eq(-1)").val($(".orderlineunits:eq(-2)").val());
            $(".orderlineprice:eq(-1)").val($(".orderlineprice:eq(-2)").val());

            calculateTotalPrice();
        });

        $('div').delegate('.orderlinedeleterow', 'click', function () {
            if ($('.orderlinerow').length <= 1) {
                return;
            }
            $(this).parents('.orderlinerow').remove();
            calculateTotalPrice();
        });

        function calculateTotalPrice() {
            var totalPrice = 0;

            $(".orderlinerow").each(function() {
                var currentPrice = 0;

                if($(this).find(".orderlineprice").val() === '') {
                    currentPrice = $(this).find(".orderlineproduct").find(":selected").data('price');
                }else{
                    currentPrice = $(this).find(".orderlineprice").val();
                }

                totalPrice += (currentPrice * $(this).find(".orderlineunits").val());
            });

            $("#totalprice").html("&euro; " + totalPrice.toFixed(2));
        }

        $('#orderlinemodal').on('change', 'input, select', function() {
            calculateTotalPrice();
        });

        calculateTotalPrice();

    </script>

@endpush