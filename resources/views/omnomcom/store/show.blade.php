<!DOCTYPE html>
<html lang="en">
    <head>
        <title>OmNomCom Store</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

        <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>
        <link rel="stylesheet" href="{{ mix('/assets/application-dark.css') }}">

        <style>
            * { box-sizing: border-box; }

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
                /**
                    Special OmNomCom monsters for special occasions. Priority is from top to bottom.
                    The first date is inclusive and should be the day when the monster should be appearing.
                    The second date is exclusive and should thus be the first day the monster should no longer be there.
                 */
                @php($bg_image = 'images/omnomcom/cookiemonster.png')
                @foreach(config('omnomcom.cookiemonsters') as $cookiemonster)
                    @if(date('U') > strtotime($cookiemonster->start) && date('U') < strtotime($cookiemonster->end))
                       @php($bg_image = "images/omnomcom/cookiemonster_seasonal/$cookiemonster->name.png")
                       @break
                    @endif
                @endforeach

                background-image: url('{{ asset($bg_image) }}');
                background-position: center 100%;
                background-repeat: no-repeat;
            }
        </style>
    </head>

    <body id="omnomcom">

        <div class="d-flex px-2">
            @include('omnomcom.store.includes.categories')

            @include('omnomcom.store.includes.product_overview')
        </div>

        @include('omnomcom.store.includes.controls')

        @include('omnomcom.store.includes.modals')

        @include('website.layouts.assets.javascripts')
        @stack('javascript')

        <script type="text/javascript" nonce="{{ csp_nonce() }}">
            let modal_status = null;
            let purchase_processing = null;
            let rfid_link_card = null;
            let cash = false;
            let bank_card = false;

            /*
             Loading the necessary data.
             */

            let images = [];
            let cart = [];
            let stock = [];
            let price = [];

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

            /*
             Registering button handlers
            */

            $('#reload-button').on('click', function () {
                window.location.reload();
            });

            $('.btn-category').on('click', function (e) {
                $(this).removeClass('inactive');
                $(this).siblings().addClass('inactive');
                $('.category-view').addClass('inactive');
                $('.category-view[data-id=' + $(this).attr('data-id') + ']').removeClass('inactive');
            });

            $('.product').on('click', function () {
                if ($(this).hasClass('random')) {
                    if ($(this).attr('data-stock') > 0) {
                        let list = $(this).attr('data-list');
                        let data = list.split(",");
                        let selected = Math.floor(Math.random() * data.length);
                        if (stock[data[selected]] < 1) {
                            $(this).trigger('click');
                            return;
                        }
                        $(this).siblings("div.product[data-id=" + data[selected] + "]").first().click();
                    } else {
                        $("#outofstock-modal").modal('show');
                    }
                } else {
                    if (stock[$(this).attr('data-id')] <= 0) {
                        $("#outofstock-modal").modal('show');
                    } else {
                        cart[$(this).attr('data-id')]++;
                        stock[$(this).attr('data-id')]--;
                        let s = stock[$(this).attr('data-id')];
                        $('.product[data-id=' + $(this).attr('data-id') + '] .product-stock').html(s + ' x');
                        update();
                    }
                }
            });

            $('#cart').on('click', '.cart-product', function () {
                cart[$(this).attr('data-id')]--;
                stock[$(this).attr('data-id')]++;
                let s = stock[$(this).attr('data-id')];
                $('.product[data-id=' + $(this).attr('data-id') + '] .product-stock').html(s + ' x');
                update();
            });

            $("#purchase-button").on('click', function () {
                $("#rfid-modal .modal-status").html("<span style='color: orange;'>Working on your purchase...<span>");
                purchase(null, 'account');
            });

            /*
             Purchase logic.
             */

            function purchase(credential, type) {
                if (purchase_processing != null) return;
                else purchase_processing = true;

                $.ajax({
                    url: '{{ route('omnomcom::store::buy', ['store' => $storeslug]) }}',
                    method: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        credentialtype: type,
                        credentials: (type !== 'account' ? credential : {
                            username: $("#purchase-username").val(),
                            password: $("#purchase-password").val()
                        }),
                        cash: {{ ($store->cash_allowed ? "cash" : "false") }},
                        bank_card: {{ ($store->bank_card_allowed ? "bank_card" : "false") }},
                        cart: cart_to_object(cart)
                    },
                    dataType: 'html',
                    success: function (data) {
                        data = JSON.parse(data);

                        if (data.status === "OK") {
                            if (!data.hasOwnProperty('message')) finishPurchase();
                            else finishPurchase(data.message);
                        } else {
                            $("#purchase-modal .modal-status").html(data.message);
                            purchase_processing = null;
                        }
                    },
                    error: function (xhr, status) {
                        purchase_processing = null;
                        if (xhr.status === 503) {
                            $("#purchase-modal .modal-status").html("The website is currently in maintenance. Please try again in 30 seconds.");
                        } else {
                            $("#purchase-modal .modal-status").html("There is something wrong with the website, call someone to help!");
                        }
                    }
                });
            }

            function finishPurchase(display_message = null) {
                $('#purchase-modal').modal('hide')
                if (display_message) {
                    $("#finished-overlay-message").html(display_message);
                }
                $("#finished-modal").modal('show');
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
                let anythingincart = false;
                let ordertotal = 0;
                for (let id in cart) {
                    if (cart[id] > 0) {
                        ordertotal += price[id] * cart[id];
                        anythingincart = true;
                        $("#cart").append(
                            '<div class="cart-product" data-id="' + id + '">' +
                                '<div class="cart-product-image">' +
                                    '<div class="cart-product-image-inner" style="background-image: url(\'' + images[id] + '\');"></div>' +
                                '</div>' +
                                '<div class="cart-product-count">' + cart[id] + 'x </div>' +
                            '</div>'
                        );
                    }
                }
                if (anythingincart) {
                    $("#purchase").removeClass("inactive");
                    $("#purchase-cash-initiate").removeClass("inactive");
                    $("#purchase-bank-card-initiate").removeClass("inactive");
                } else {
                    $("#purchase").addClass("inactive");
                    $("#purchase-cash-initiate").addClass("inactive");
                    $("#purchase-bank-card-initiate").addClass("inactive");
                }
                $("#total").html(ordertotal.toFixed(2));

                let lists = $('.random');
                for (let i = 0; i < lists.length; i++) {
                    let count = 0;
                    let products = $(lists[i]).siblings();
                    for (let j = 0; j < products.length; j++) {
                        if (stock[$(products[j]).attr('data-id')] > 0) count++;
                    }
                    $(lists[i]).attr('data-stock', count);
                }
            }

            /*
             RFID scanner integration
             */

            let server;

            establishNfcConnection();

            function establishNfcConnection() {
                try {
                    $("#status").addClass("inactive").html("RFID Service: Connecting...");
                    server = new WebSocket("ws://localhost:3000", "nfc");
                } catch (err) {
                    if (err.message.indexOf("insecure") !== -1) {
                        $("#status").addClass("inactive").html("RFID Service: Not Supported");
                        return;
                    } else {
                        console.log("Unexpected error:", err.message);
                    }
                }

                server.onopen = function () {
                    $("#status").removeClass("inactive").html("RFID Service: Connected");
                };

                server.onclose = function () {
                    $("#status").addClass("inactive").html("RFID Service: Disconnected");
                    setTimeout(establishNfcConnection, 5000);
                };

                server.onmessage = function (raw) {
                    let data = JSON.parse(raw.data).uid;
                    console.log('Received card input: ' + data);

                    if (modal_status === "badcard") {
                        return;
                    }

                    if (data === "") {
                        $(".modal").modal('hide');
                        $("#badcard-modal").modal('show');
                        modal_status = "badcard";
                        return;
                    }

                    $("#badcard-modal").modal('hide');

                    if (modal_status === 'rfid') {

                        if (rfid_link_card == null) {
                            rfid_link_card = data;
                            $("#rfid-modal .modal-body").html('<div class="qrAuth">Loading QR authentication...</div>\n' +
                                '\n' +
                                '        <hr>\n' +
                                '\n' +
                                '        <span class="modal-status">\n' +
                                '            Authenticate using the QR code above to link RFID card.\n' +
                                '        </span>');
                            doQrAuth($("#rfid-modal .qrAuth"), "Link RFID card to account", function (auth_token, credentialtype) {
                                $.ajax({
                                    url: '{{ route('omnomcom::store::rfidadd') }}',
                                    method: 'post',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        card: rfid_link_card,
                                        credentialtype: credentialtype,
                                        credentials: auth_token,
                                    },
                                    dataType: 'html',
                                    success: function (data) {
                                        $("#rfid-modal .modal-status").html(data);
                                    }
                                });
                            });
                        }

                    } else if (modal_status === 'purchase') {
                        purchase(data, 'card');
                    } else {
                        let anythingincart = false;
                        for (let id in cart) {
                            if (cart[id] > 0) {
                                anythingincart = true;
                            }
                        }
                        if (anythingincart) {
                            $("#purchase").trigger('click');
                            purchase(data, 'card');
                        } else {
                            $("#emptycart-modal").modal('show');
                        }

                    }

                };
            }

            function doQrAuth(element, description, onComplete) {
                let auth_token = null;

                $.ajax({
                    url: '{{ route('qr::generate') }}',
                    method: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        description: description
                    },
                    dataType: 'json',
                    success: function (data) {
                        element.html('Scan this QR code<br><br><img src="{{ route('qr::code', '') }}/' + data.qr_token + '" width="200px" height="200px"><br><br>or go to<br><strong>{{ route('qr::dialog', '') }}/' + data.qr_token + "</strong>");
                        auth_token = data.auth_token;

                        let qrAuthInterval = setInterval(function () {
                            // Stop checking if the modal has been dismissed.
                            if (modal_status == null) {
                                clearInterval(qrAuthInterval);
                                return;
                            }

                            $.ajax({
                                url: '{{ route('qr::approved') }}',
                                method: 'get',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    code: auth_token
                                },
                                dataType: 'json',
                                success: function (data) {
                                    if (data) {
                                        element.html('Successfully authenticated :)');
                                        clearInterval(qrAuthInterval);
                                        onComplete(auth_token, 'qr');
                                    }
                                }
                            });
                        }, 1000);
                    }
                });

            }

            /*
             Modal handlers
             */

            $("#rfid").on("click", function () {
                rfid_link_card = null;
                modal_status = 'rfid';
                $("#rfid-modal").modal('show')
                $("#rfid-modal .modal-body").html("<h1>Please present your RFID card</h1>");
            });

            $("#purchase").on("click", function () {
                $("#purchase-modal").modal('show');
                doQrAuth($("#purchase-modal .qrAuth"), "Payment of €" + $("#total").html() + " for purchases in Omnomcom", purchase);

                $("#purchase-modal h1").html("Complete purchase using your <i class=\"fas fa-cookie-bite\"></i> OmNomCom bill.");
                cash = false;
                bank_card = false;
                modal_status = 'purchase';
            });

            $("#purchase-cash-initiate").on("click", function () {
                $("#purchase-modal").modal('show');
                doQrAuth($("#purchase-modal .qrAuth"), "Cashier payment for cash purchases in Omnomcom", purchase);

                $("#purchase-modal h1").html("Complete purchase as cashier, payed with cash.");
                cash = true;
                bank_card = false;
                modal_status = 'purchase';
            });

            $("#purchase-bank-card-initiate").on("click", function () {
                $("#purchase-modal").modal('show')
                $("#purchase-bank-card").addClass('modal-toggle-true');
                doQrAuth($("#purchase-modal .qrAuth"), "Cashier payment for bank card purchases in Omnomcom", purchase);

                $("#purchase-modal h1").html("Complete purchase as cashier, payed with bank card.");
                cash = false;
                bank_card = true;
                modal_status = 'purchase';
            });


            /*
             Handle idle timeout
             */

            let idleTime = 0;
            let idleWarning = false;

            $(function () {
                //Increment the idle time counter every minute.
                let idleInterval = setInterval(timerIncrement, 1000); // 1 second

                //Zero the idle timer on mouse movement.
                $(this).on('mousemove', function (e) {
                    idleTime = 0;
                    idleWarning = false;
                });
                $(this).on('keydown', function (e) {
                    idleTime = 0;
                    idleWarning = false;
                });
            });

            // Called each minute
            function timerIncrement() {
                idleTime = idleTime + 1;

                if (idleTime > 60 && !idleWarning) {
                    let anythingincart = false;

                    for (let id in cart) {
                        if (cart[id] > 0) {
                            anythingincart = true;
                        }
                    }

                    if (anythingincart && !$(".modal").data('bs.modal')?._isShown) {
                        idleWarning = true;
                        $("#idlewarning-modal").modal('show');

                        setTimeout(function () {
                            if (idleWarning) window.location.reload();
                        }, 10000);
                    }
                }
            }

            function cart_to_object(cart) {
                let object_cart = {};

                for (let product_id in cart) {
                    if (cart[product_id] > 0) {
                        object_cart[product_id] = cart[product_id]
                    }
                }

                return object_cart;
            }
        </script>
    </body>
</html>
