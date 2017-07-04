<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>OmNomCom Store</title>

    @include('website.layouts.assets.stylesheets')

    <style type="text/css">

        * {
            box-sizing: border-box;
        }

        html, body {
            position: absolute;

            font-family: Lato, sans-serif;

            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            margin: 0;
            padding: 0;

            background-color: #555;
        }

        body {
            background-image: url('{{ asset('images/omnomcom/cookiemonster.png') }}');
            background-position: center 115%;
            background-repeat: no-repeat;
        }

        #reload-button {
            margin-top: 70px;
            opacity: 0;
        }

        #category_nav {
            position: absolute;

            top: 0;
            left: 20px;
            bottom: 0;
            width: 280px;

            padding: 20px 20px;

            background-color: #333;

            box-shadow: 0 0 20px -7px #000;
        }

        .category_button {
            width: 100%;
            height: 50px;

            line-height: 50px;

            padding-left: 20px;

            margin-bottom: 20px;

            text-transform: uppercase;
            font-size: 18px;

            color: #fff;

            background-color: #26ADE4;

            box-shadow: 0 0 20px -7px #000;

            transition: all 0.2s;
            opacity: 1;
            transform: translate(30px, 0);
        }

        .category_button.inactive {
            opacity: 0.6;
            transform: translate(0, 0);
        }

        .category_view {
            position: absolute;

            top: 0;
            left: 0;
            right: 20px;
            bottom: 0;

            transition: all 0.5s;
            transform: translate(0, 0);
            opacity: 1;

            z-index: 100;
        }

        .category_view.inactive {
            transform: translate(0, -100%);
            opacity: 0;

            z-index: 0;
        }

        #product_nav {
            position: absolute;

            top: 0;
            left: 300px;
            right: 0;
            bottom: 110px;

            overflow: auto;
        }

        .product {
            width: 20%;
            height: 150px;

            padding: 20px 0 0 20px;

            float: left;
        }

        .product.nostock {
            opacity: 0.5;
        }

        .product-inner {
            position: relative;

            width: 100%;
            height: 130px;
            background-color: #333;

            color: #fff;
        }

        .product-details {
            position: absolute;

            top: 0;
            left: 130px;
            right: 0;
            bottom: 0;

            background-color: #333;
        }

        .product-name {
            margin: 10px;
            text-align: right;
            font-size: 20px;
            max-height: 56px;

            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-price {
            position: absolute;

            bottom: 10px;
            left: -50px;
            padding: 10px;

            color: #fff;

            font-weight: bold;

            background-color: #26ADE4;
        }

        .product-stock {
            position: absolute;

            bottom: 10px;
            right: 10px;
            padding: 10px;

            color: #fff;

            background-color: #111;
        }

        .nostock .product-stock {
            display: none;
        }

        .product-image {
            position: absolute;

            top: 20px;
            left: 20px;
            bottom: 20px;

            padding: 15px;

            width: 90px;

            border-radius: 45px;

            background-color: #111;
        }

        .product-image-inner {
            width: 100%;
            height: 100%;

            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;

            padding: 10px;
        }

        #controls {
            position: absolute;

            left: 0;
            right: 0;
            bottom: 40px;
            height: 70px;

            box-shadow: 0 0 20px -7px #000;

            background-color: #26ADE4;
        }

        #cart {
            position: absolute;
            left: 40px;
            bottom: 0;
            top: -20px;
        }

        .cart-product {
            position: relative;

            float: left;

            width: 90px;
            height: 90px;

            margin-top: 10px;
            margin-right: 10px;

            border-radius: 45px;

            background-color: #111;

            border: 10px solid #26ADE4;
        }

        .cart-product-image {
            position: absolute;

            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            padding: 15px;
        }

        .cart-product-image-inner {
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;

            width: 100%;
            height: 100%;
        }

        .cart-product-count {
            position: absolute;

            right: -10px;
            bottom: -10px;

            padding: 10px;

            font-weight: bold;

            color: #333;

            box-shadow: 0 0 20px -5px #000;

            background-color: #26ADE4;
        }

        #buttons {
            position: absolute;

            overflow: hidden;

            top: 10px;
            right: 0;
            bottom: 10px;

            padding-right: 10px;

            width: 100%;
        }

        .button {
            height: 50px;
            margin-right: 20px;

            line-height: 50px;

            padding-right: 15px;
            padding-left: 15px;

            float: right;

            font-size: 20px;

            background-color: #333;
            color: #fff;
        }

        #purchase, #purchase-cash-initiate {
            transition: all 0.5s;
            transform: translate(0, 0);
            opacity: 1;
        }

        #purchase.inactive, #purchase-cash-initiate.inactive {
            transform: translate(200px, 0);
            opacity: 0;
        }

        #logout-button {
            margin-top: 50px;
        }

        #purchase-movie {
            margin-top: 50px;
            margin-bottom: -57px;
        }

        .info {
            height: 50px;
            margin-right: 20px;

            line-height: 50px;

            float: right;

            color: #fff;

            font-size: 20px;

            transition: all 0.5s;
            opacity: 1;
        }

        .info.inactive {
            opacity: 0.5;
        }

        .modal-overlay {
            position: absolute;

            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            background-color: rgba(0, 0, 0, 0.8);

            z-index: 200;

            overflow: hidden;

            display: none;
        }

        .modal {
            width: 700px;
            margin: 150px auto;

            /* This overrides bootstrap */
            bottom: auto !important;

            text-align: center;

            overflow: hidden;

            padding: 50px;

            background-color: #333;

            display: block;

            box-shadow: 0 0 20px -7px #000;
        }

        .modal.inactive {
            display: none;
        }

        .modal h1 {
            color: #fff;
            font-size: 25px;
            margin-bottom: 50px;
        }

        .modal .modal-status {
            margin-bottom: 50px;
            color: #fff;
            font-size: 20px;
        }

        .modal .modal-input {
            padding: 10px;
            width: 290px;

            border: none;

            font-size: 15px;
            margin-bottom: 50px;
        }

        .modal .modal-button {
            margin: -40px auto 0 auto;

            background-color: #111111;

            padding: 20px 50px;

            text-align: center;
            color: #fff;
            font-size: 20px;
        }

        .modal .modal-toggle {
            margin: 10px auto 0 auto;

            background-color: #111111;

            padding: 20px 50px;

            text-align: center;
            color: #fff;
            font-size: 20px;
        }

        .modal .modal-toggle.modal-toggle-true {
            background-color: green;
        }

        .modal hr {
            margin: 40px 0;
        }

    </style>

    <style type="text/css">

        #osk-container {
            z-index: 2000 !important;
            width: 50% !important;
        }

    </style>

</head>

<body>

<div id="category_nav">

    @foreach($categories as $category)

        <div class="category_button {{ ($category == $categories[0] ? '' : 'inactive') }}"
             data-id="{{ $category->category->id }}">
            {{ $category->category->name }}
        </div>

    @endforeach

    <div class="category_button inactive" id="reload-button">
        RELOAD BUTTON
    </div>

</div>

<div id="product_nav">

    @foreach($categories as $category)

        <?php $products_in_category = []; ?>

        <div class="category_view {{ ($category == $categories[0] ? '' : 'inactive') }}"
             data-id="{{ $category->category->id }}">

            @foreach($category->products as $product)

                @if($product->isVisible())

                    <?php
                    if ($product->stock > 0) {
                        $products_in_category[] = $product->id;
                    }
                    ?>

                    <div class="product {{ ($product->stock <= 0 ? 'nostock' : '') }}"
                         data-id="{{ $product->id }}" data-stock="{{ $product->stock }}"
                         data-price="{{ $product->price }}">

                        <div class="product-inner">

                            <div class="product-image">
                                @if($product->image)
                                    <div class="product-image-inner"
                                         style="background-image: url('{!! $product->image->generateImagePath(100, null) !!}');"></div>
                                @endif
                            </div>

                            <div class="product-details">

                                <div class="product-name">
                                    {{ $product->name }}
                                </div>

                                <div class="product-price">
                                    &euro; {{ number_format($product->price, 2, '.', '') }}
                                </div>

                                @if ($product->stock < 1000)
                                    <div class="product-stock">
                                        {{ $product->stock }} x
                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

            @if (count($products_in_category) > 0)

                <div class="product random {{ (count($products_in_category) <= 1 ? 'nostock' : '') }}"
                     data-list="{{ implode(",", $products_in_category) }}"
                     data-stock="{{ count($products_in_category) }}">

                    <div class="product-inner">

                        <div class="product-image">
                            <div class="product-image-inner"
                                 style="background-image: url('{{ asset('images/omnomcom/dice_v2.png')}}');"></div>
                        </div>

                        <div class="product-details">

                            <div class="product-name">
                                I'm feeling lucky!
                            </div>

                            <div class="product-price">
                                Who knows?
                            </div>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    @endforeach

</div>

<div id="controls">

    <div id="buttons">

        <span id="purchase" class="button inactive">Complete order</span>
        @if($store->cash_allowed)
            <span id="purchase-cash-initiate" class="button inactive">Complete with cash</span>
        @endif
        <span id="rfid" class="button">Link RFID card</span>
        <span class="info" style="font-weight: bold;">Order total: &euro;<span id="total">0.00</span></span>
        <span id="status" class="info inactive">RFID Service: Disconnected</span>

    </div>

    <div id="cart">

    </div>

</div>

<div id="finished-overlay" class="modal-overlay">

    <div id="finished-modal" class="modal inactive">

        <h1>Your purchase has completed.</h1>

        <div class="modal-input modal-button" id="logout-button">CONTINUE</div>

        <video id="purchase-movie" width="473" height="260">
            <source src="{{ asset('videos/omnomcom.webm') }}" type="video/webm">
        </video>

    </div>

</div>

<div id="modal-overlay" class="modal-overlay">

    <div id="rfid-modal" class="modal inactive">

        <h1>Link an RFID card to your account.</h1>

        <input class="modal-input with-keyboard" data-osk-options="disableReturn disableTab" id="rfid-username"
               type="text" placeholder="Proto username">
        <input class="modal-input with-keyboard" data-osk-options="disableReturn disableTab" id="rfid-password"
               type="password"
               placeholder="Proto password">

        <span class="modal-status">
            First enter your <strong>Proto</strong> username and password, then present an RFID card.
        </span>

    </div>

    <div id="outofstock-modal" class="modal inactive">

        <h1>The product you selected is out of stock.</h1>

    </div>

    <div id="idlewarning-modal" class="modal inactive">

        <h1>Timeout warning!</h1>
        <span class="modal-status">If you want to continue using the OmNomCom, please touch the screen.</span>

    </div>

    <div id="emptycart-modal" class="modal inactive">

        <h1>The cart is empty. Please fill the cart before scanning your card :)</h1>

    </div>

    <div id="purchase-modal" class="modal inactive">

        <h1>Complete your purchase.</h1>

        <input class="modal-input with-keyboard" data-osk-options="disableReturn disableTab" id="purchase-username"
               type="text"
               placeholder="Proto username">
        <input class="modal-input with-keyboard" data-osk-options="disableReturn disableTab" id="purchase-password"
               type="password"
               placeholder="Proto password">

        <div class="modal-input modal-button" id="purchase-button">Complete order</div>
        @if($store->cash_allowed)
            <div class="modal-input modal-toggle" id="purchase-cash">Pay with Cash</div>
        @endif
        <hr>

        <span class="modal-status">
            Enter your <strong>Proto</strong> credentials above, or present an RFID card.
        </span>

    </div>

</div>

@section('javascript')
    @include('website.layouts.assets.javascripts')
@show

<script type="text/javascript">

    $('.with-keyboard').onScreenKeyboard({
        'topPosition': '50%',
        'leftPosition': '25%'
    });

    var modal_status = null;

    /*
     Loading the necessary data.
     */

    var images = [];
    var cart = [];
    var stock = [];
    var price = [];

    //--formatter:off
    @foreach($categories as $category)
        @foreach($category->products as $product)
            @if($product->isVisible())
                @if($product->image)
                    images[{{ $product->id }}] = '{!! $product->image->generateImagePath(100, null) !!}';
                @endif
                cart[{{ $product->id }}] = 0;
                stock[{{ $product->id }}] = {{ $product->stock }};
                price[{{ $product->id }}] = {{ $product->price }};
            @endif
        @endforeach
    @endforeach
    //--formatter:on

    /*
     Registering button handlers
     */

    $('#reload-button').on('click', function () {
        window.location.reload();
    });

    $('.modal-toggle').on('click', function () {
        $(this).toggleClass('modal-toggle-true');
    });

    $('.category_button').on('click', function () {
        $('.category_button').addClass('inactive');
        $('.category_button[data-id=' + $(this).attr('data-id') + ']').removeClass('inactive');
        $('.category_view').addClass('inactive');
        $('.category_view[data-id=' + $(this).attr('data-id') + ']').removeClass('inactive');
    });

    $('.product').on('click', function () {

        if ($(this).hasClass('random')) {
            if ($(this).attr('data-stock') > 0) {
                var list = $(this).attr('data-list');
                var data = list.split(",");
                var selected = Math.floor(Math.random() * data.length);

                if (stock[data[selected]] < 1) {
                    $(this).click();
                    return;
                }

                $(this).siblings("div.product[data-id=" + data[selected] + "]").first().click();
            } else {
                $("#modal-overlay").show();
                $("#outofstock-modal").removeClass('inactive');
            }

        } else {

            if (stock[$(this).attr('data-id')] <= 0) {

                $("#modal-overlay").show();
                $("#outofstock-modal").removeClass('inactive');

            } else {

                cart[$(this).attr('data-id')]++;
                stock[$(this).attr('data-id')]--;

                var s = stock[$(this).attr('data-id')];
                $('.product[data-id=' + $(this).attr('data-id') + '] .product-stock').html(s + ' x');

                update();

            }

        }

    })

    $('#cart').delegate('.cart-product', 'click', function () {

        cart[$(this).attr('data-id')]--;
        stock[$(this).attr('data-id')]++;

        var s = stock[$(this).attr('data-id')];
        $('.product[data-id=' + $(this).attr('data-id') + '] .product-stock').html(s + ' x');

        update();

    });

    $("#purchase-button").on("click", function () {

        $("#rfid-modal .modal-status").html("<span style='color: orange;'>Working on your purchase...<span>");
        purchase(null);

    });

    /*
     Purchase logic.
     */

    function purchase(card) {

        $.ajax({
            url: '{{ route('omnomcom::store::buy', ['store' => $storeslug]) }}',
            method: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                credentialtype: (card !== null ? 'card' : 'account'),
                credentials: (card !== null ? card : {
                    username: $("#purchase-username").val(),
                    password: $("#purchase-password").val()
                }),
                cash: {!! ($store->cash_allowed ? "$('#purchase-cash').hasClass('modal-toggle-true')" : "false") !!},
                cart: cart
            },
            dataType: 'html',
            success: function (data) {
                if (data == "OK") {
                    finishPurchase();
                } else {
                    $("#purchase-modal .modal-status").html(data);
                }
            },
            error: function (xhr, status) {
                if (xhr.status == 503) {
                    $("#purchase-modal .modal-status").html("The website is currently in maintenance. Please try again in 30 seconds.");
                } else {
                    $("#purchase-modal .modal-status").html("There is something wrong with the website, call someone to help!");
                }
            }
        })
        ;

    }

    $('#logout-button').on('click', function () {
        window.location.reload();
    });

    function finishPurchase() {
        $('#modal-overlay').trigger('click');
        $("#finished-overlay").show();
        $("#finished-modal").removeClass('inactive');
        document.getElementById("purchase-movie").play();
        setTimeout(function () {
            window.location.reload();
        }, 7000);
    }

    /*
     Cart logic.
     */

    function update() {
        $("#cart").html("");
        var anythingincart = false;
        var ordertotal = 0;
        for (id in cart) {
            if (cart[id] > 0) {
                ordertotal += price[id] * cart[id];
                anythingincart = true;
                $("#cart").append('<div class="cart-product" data-id="' + id + '"><div class="cart-product-image"><div class="cart-product-image-inner" style="background-image: url(\'' + images[id] + '\');"></div></div><div class="cart-product-count">' + cart[id] + 'x</div></div>');
            }
        }
        if (anythingincart) {
            $("#purchase").removeClass("inactive");
            $("#purchase-cash-initiate").removeClass("inactive");
        } else {
            $("#purchase").addClass("inactive");
            $("#purchase-cash-initiate").addClass("inactive");
        }
        $("#total").html(ordertotal.toFixed(2));


        var lists = $('.random');
        for (var i = 0; i < lists.length; i++) {
            var count = 0;
            var products = $(lists[i]).siblings();
            for (var j = 0; j < products.length; j++) {
                if (stock[$(products[j]).attr('data-id')] > 0) count++;
            }
            $(lists[i]).attr('data-stock', count);
        }
    }

    /*
     RFID scanner integration
     */

    if (navigator.userAgent.indexOf('Electron') >= 0) {

        var server = new WebSocket("ws://localhost:3000", "nfc");

        server.onopen = function () {
            $("#status").removeClass("inactive").html("RFID Service: Connected");
        };

        server.onclose = function () {
            $("#status").addClass("inactive").html("RFID Service: Reconnecting");
        };

        server.onmessage = function (raw) {
            data = JSON.parse(raw.data).uid;
            console.log('Received card input: ' + data);

            if (modal_status == 'rfid') {

                if ($("#rfid-username").val() == '' || $("#rfid-password").val() == '') {
                    $("#rfid-modal .modal-status").html("<span style='color: red;'>Enter your account details before presenting an RFID card.<span>");
                } else {

                    $("#rfid-modal .modal-status").html("<span style='color: orange;'>Trying to register your card...<span>");

                    $.ajax({
                        url: '{{ route('omnomcom::store::rfidadd') }}',
                        method: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            card: data,
                            username: $("#rfid-username").val(),
                            password: $("#rfid-password").val()
                        },
                        dataType: 'html',
                        success: function (data) {
                            $("#rfid-modal .modal-status").html(data);
                        }
                    });

                }

            } else if (modal_status == 'purchase') {

                purchase(data);

            } else {

                var anythingincart = false;

                for (id in cart) {
                    if (cart[id] > 0) {
                        anythingincart = true;
                    }
                }

                if (anythingincart) {
                    $("#purchase").trigger('click');
                    purchase(data);
                } else {
                    $("#modal-overlay").show();
                    $("#emptycart-modal").removeClass('inactive');
                }

            }

        };

    }

    /*
     Modal handlers
     */

    $(".modal").on("click", function (e) {
        return false;
    });

    $("#modal-overlay").on("click", function () {
        $(".modal").addClass('inactive');
        $("#modal-overlay").hide();
        $(".modal-input").val('');
        $("#osk-container .osk-hide").trigger('click');
        $("#purchase-cash").removeClass('modal-toggle-true');
        modal_status = null;
    });

    $("#rfid").on("click", function () {
        $("#modal-overlay").show();
        $("#rfid-modal").removeClass('inactive');
        modal_status = 'rfid';
    });

    $("#purchase").on("click", function () {
        $("#modal-overlay").show();
        $("#purchase-modal").removeClass('inactive');
        modal_status = 'purchase';
    });

    $("#purchase-cash-initiate").on("click", function () {
        $("#modal-overlay").show();
        $("#purchase-modal").removeClass('inactive');
        $("#purchase-cash").addClass('modal-toggle-true');
        modal_status = 'purchase';
    });


    /*
     Handle idle timeout
     */

    var idleTime = 0;
    var idleWarning = false;

    $(document).ready(function () {
        //Increment the idle time counter every minute.
        var idleInterval = setInterval(timerIncrement, 1000); // 1 second

        //Zero the idle timer on mouse movement.
        $(this).mousemove(function (e) {
            idleTime = 0;
            idleWarning = false;
        });
        $(this).keypress(function (e) {
            idleTime = 0;
            idleWarning = false;
        });
    });

    function timerIncrement() {
        idleTime = idleTime + 1;

        if (idleTime > 60 && !idleWarning) { // 1 minutes
            var anythingincart = false;

            for (id in cart) {
                if (cart[id] > 0) {
                    anythingincart = true;
                }
            }

            if (anythingincart) {
                idleWarning = true;
                $("#modal-overlay").show();
                $("#idlewarning-modal").removeClass('inactive');

                setTimeout(function () {
                    if (idleWarning) window.location.reload();
                }, 10000);
            }
        }
    }


</script>

</body>

</html>
