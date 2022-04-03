<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>OmNomCom Store</title>

        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='initial-scale=1, maximum-scale=1, user-scalable=no'/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        <link rel='shortcut icon' href='{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}'/>
        <link rel='stylesheet' href='{{ mix('/css/application-dark.css') }}'>

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
                       @php($bg_image = 'images/omnomcom/cookiemonster_seasonal/$cookiemonster->name.png')
                       @break
                    @endif
                @endforeach

                background-image: url('{{ asset($bg_image) }}');
                background-position: center 100%;
                background-repeat: no-repeat;
            }
        </style>
    </head>

    <body>

        <div id="display-fullscreen" class="modal" tabindex="-1">
            <div class="modal-dialog-centered mx-auto">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title w-100">Please display OmNomCom in fullscreen!</h5>
                    </div>
                    <div class="modal-body d-flex justify-content-center pb-0">
                        <img src="{{ asset('images/omnomcom/cookiemonster_seasonal/pixels.png') }}" alt="cookie monster">
                    </div>
                </div>
            </div>
        </div>

        <div id="omnomcom">

            <div class='d-flex ps-2'>
                @include('omnomcom.store.includes.categories')

                @include('omnomcom.store.includes.product_overview')
            </div>

            @include('omnomcom.store.includes.controls')

        </div>

        @include('omnomcom.store.includes.modals')

        @include('website.layouts.assets.javascripts')

        <script type='text/javascript' nonce='{{ csp_nonce() }}'>
            let modalStatus = null;
            let purchaseProcessing = null;
            let rfidLinkCard = null;
            let cash = false;
            let bankCard = false;

            /* Load the necessary data. */
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

            /* Register button handlers */
            document.getElementById('reload-button').addEventListener('click', _ => {
                window.location.reload()
            })

            const categoryBtnList = Array.from(document.getElementsByClassName('btn-category'))
            categoryBtnList.forEach(el => {
                el.addEventListener('click', _ => {
                    Array.from(el.parent.childNodes).forEach(el => el.classList.add('inactive'))
                    el.classList.remove('inactive')
                    const categoryViewList = Array.from(document.getElementsByClassName('category-view'))
                    const id = el.getAttribute('data-id')
                    categoryViewList.forEach(el => {
                        if (el.getAttribute('data-id') !== id) el.classList.add('inactive')
                        else el.classList.remove('inactive')
                    })
                })
            })

            const productList = Array.from(document.getElementsByClassName('product'))
            productList.forEach(el => {
                el.addEventListener('click', _ => {
                    if (el.classList.contains('random')) {
                        if (el.getAttribute('data-stock') > 0) {
                            let data = el.getAttribute('data-list').split('')
                            let selected = Math.floor(Math.random() * data.length)
                            if (stock[data[selected]] < 1)
                                return el.dispatchEvent(new Event('click'))
                            const product = document.querySelector(`.product[data-id=${data[selected]}]`)
                            product.dispatchEvent(new Event('click'))
                        } else {
                            modals['outofstock-modal'].show()
                        }
                    } else {
                        const id = el.getAttribute('data-id')
                        if (stock[id] <= 0) {
                            modals['outofstock-modal'].show()
                        } else {
                            cart[id]++
                            stock[id]--
                            const s = stock[id]
                            document.querySelector(`.product[data-id=${id}] .product-stock`).innerHTML = s + ' x'
                            update()
                        }
                    }
                })
            })

            document.getElementById('cart').addEventListener('click', e => {
                if(e.target.classList.contains('cart-product')) {
                    const id = e.target.getAttribute('data-id')
                    cart[id]--
                    stock[id]++
                    const s = stock[id]
                    document.querySelector(`.product[data-id=${id}] .product-stock`).innerHTML = s + ' x'
                    update()
                }
            })

            document.getElementById('purchase').addEventListener('click', e => {
                document.querySelector('#rfic-modal .modal-status').innerHTML = '<span class="text-warning" >Working on your purchase...<span>'
                purchase(null, 'account')
            })

            /* Purchase logic. */
            function purchase(credential, type) {
                if (purchaseProcessing != null) return
                else purchaseProcessing = true

                post(
                    '{{ route('omnomcom::store::buy', ['store' => $storeslug]) }}', {
                    credentialtype: type,
                    credentials: (type !== 'account' ? credential : {
                        username: document.getElementById('purchase-username').value,
                        password: document.getElementById('purchase-password').value
                    }),
                    cash: {{ ($store->cash_allowed ? 'cash' : 'false') }},
                    bank_card: {{ ($store->bank_card_allowed ? 'bank_card' : 'false') }},
                    cart: cart_to_object(cart)
                }, { parse: false })
                .then(res => {
                    const data = res.json()
                    if (res.status === 200) {
                        if (data.hasOwnProperty('message')) finishPurchase()
                        else finishPurchase(data.message)
                    } else {
                        document.querySelector('#purchase-modal .modal-status').innerHTML = data.message
                        purchaseProcessing = null
                    }
                })
                .catch(err => {
                    const status = document.querySelector('#purchase-modal .modal-status')
                    purchaseProcessing = null
                    if (err.status === 503) status.innerHTML = 'The website is currently in maintenance. Please try again in 30 seconds.'
                    else status.innerHTML = 'There is something wrong with the website, call someone to help!'
                })
            }

            function finishPurchase(display_message = null) {
                modals.forEach(el => el.hide())
                if (display_message) document.getElementById('finished-modal-message').innerHTML = display_message
                document.getElementById('finished-modal-continue').addEventListener('click', _ => window.location.reload())
                modals['finished-modal'].show()
                const movie = document.getElementById('purchase-movie')
                movie.addEventListener('ended', e => window.location.reload())
                movie.dispatchEvent(new Event('play'))
            }

            /* Cart logic. */
            function update() {
                const cartEl = document.getElementById('cart')
                cartEl.innerHTML = ''
                let anythingInCart = false
                const orderTotal = cart.reduce((total, id) => {
                    anythingInCart = true
                    cartEl.innerHTML +=
                        '<div class="cart-product" data-id="' + id + '">' +
                            '<div class="cart-product-image">' +
                                '<div class="cart-product-image-inner" style="background-image: url(' + images[id] + ');"></div>' +
                            '</div>' +
                            '<div class="cart-product-count">' + cart[id] + 'x </div>' +
                        '</div>'
                    return total + price[id] * cart[id]
                })

                const purchaseEls = document.querySelectorAll('#purchase, #purchase-cash-initiate, #purchase-bank-card-initiate')
                if (anythingInCart) purchaseEls.forEach(el => el.classList.remove('inactive'))
                else purchaseEls.forEach(el => el.classList.add('inactive'))
                document.getElementById('total').innerHTML = orderTotal.toFixed(2)

                let lists = document.getElementsByClassName('random')
                for (let i = 0; i < lists.length; i++) {
                    let count = 0
                    let products = lists[i].parent.children
                    products.splice(products.indexOf(lists[i]), 1)
                    for (let j = 0; j < products.length; j++) {
                        if (stock[products[j].getAttribute('data-id')] > 0) count++
                    }
                    lists[i].setAttribute('data-stock', count.toString())
                }
            }

            /* RFID scanner integration */
            let server;

            establishNfcConnection()

            function establishNfcConnection() {
                const status = document.getElementById('status')
                try {
                    status.classList.add('inactive')
                    status.innerHTML = 'RFID Service: Connecting...'
                    server = new WebSocket('ws://localhost:3000', 'nfc')
                } catch (error) {
                    if (error.message.indexOf('insecure') !== -1) {
                        status.classList.add('inactive')
                        status.innerHTML = 'RFID Service: Not Supported'
                    } else {
                        console.error('Unexpected error: ' + error.message)
                    }
                }

                server.onopen = _ => {
                    status.classList.remove('inactive')
                    status.innerHTML = 'RFID Service: Connected'
                }

                server.onclose = _ => {
                    status.classList.add('inactive')
                    status.innerHTML = 'RFID Service: Disconnected'
                    setTimeout(establishNfcConnection, 5000)
                }

                server.onmessage = raw => {
                    let data = JSON.parse(raw.data).uid
                    console.log('Received card input: ' + data)

                    if (modalStatus === 'badcard') return

                    if (data === '') {
                        modals.forEach(el => el.hide())
                        modals['badcard-modal'].show()
                        modalStatus = 'badcard'
                        return
                    }

                    modals['badcard-modal'].hide()

                    if (modalStatus === 'rfid') {

                        if (rfidLinkCard == null) {
                            rfidLinkCard = data;
                            document.querySelector('#rfid-modal .modal-body').innerHTML =
                                '<div class="qrAuth">Loading QR authentication...</div>' +
                                '<hr>' +
                                '<span class="modal-status">Authenticate using the QR code above to link RFID card.</span>'
                            doQrAuth(
                                document.querySelector('#rfid-modal .qrAuth'),
                                'Link RFID card to account',
                                (auth_token, credentialtype) => {
                                    post(
                                        '{{ route('omnomcom::store::rfidadd') }}',
                                        {
                                            card: rfidLinkCard,
                                            credentialtype: credentialtype,
                                            credentials: auth_token,
                                        }
                                    )
                                    .then(data => document.querySelector('#rfid-modal .modal-status').innerHTML = '<span class="' + (data.ok ? 'primary' : 'danger') + '">' + data.text + '</span>')
                                }
                            )
                        }

                    } else if (modalStatus === 'purchase') {
                        purchase(data, 'card')
                    } else {
                        let anythingInCart = false
                        for (let id in cart) if (cart[id] > 0) anythingInCart = true
                        if (anythingInCart) purchase(data, 'card')
                        else modals['emptycart-modal'].show()
                    }
                }
            }

            function doQrAuth(element, description, onComplete) {
                let authToken = null
                post('{{ route('qr::generate') }}', { description: description })
                .then(data => {
                    const qrImg = "{{ route('qr::code', '') }}" + '/' + data.qr_token
                    const qrLink = "{{ route('qr::dialog', '') }}" + '/' + data.qr_token
                    element.innerHTML = 'Scan this QR code<br><br><img src="' +  qrImg + '" width="200px" height="200px"><br><br>or go to<br><strong>' + qrLink + '</strong>'
                    authToken = data.auth_token
                    const qrAuthInterval = setInterval(_ => {
                        if (modalStatus == null) return clearInterval(qrAuthInterval)
                        get('{{ route('qr::approved') }}', { code: authToken })
                        .then(_ => {
                            element.innerHTML = 'Successfully authenticated :)'
                            clearInterval(qrAuthInterval)
                            onComplete(authToken, 'qr')
                        })
                    }, 1000)
                })
            }

            /* Modal handlers */
            document.getElementById('rfid').addEventListener('click', _ => {
                rfidLinkCard = null
                modalStatus = 'rfid'
                modals['rfid-modal'].show()
                document.querySelector('#rfid-modal .modal-body').innerHTML = '<h1>Please present your RFID card</h1>'
            })

            document.getElementById('purchase').addEventListener('click', _ => purchaseInitiate(
                [false, false],
                'Payment of €' + document.getElementById('total').innerHTML + ' for purchases in Omnomcom',
                'Complete purchase using your <i class="fas fa-cookie-bite"></i> OmNomCom bill.'
            ))

            cashCompleted = document.getElementById('purchase-cash-initiate')
            if(cashCompleted) {
                cashCompleted.addEventListener('click', _ => purchaseInitiate(
                    [true, false],
                    'Cashier payment for cash purchases in Omnomcom',
                    'Complete purchase as cashier, payed with cash.'
                ))
            }

            cardCompleted = document.getElementById('purchase-bank-card-initiate')
            if(cardCompleted) {
                cardCompleted.addEventListener('click', _ => purchaseInitiate(
                    [false, true],
                    'Cashier payment for bank card purchases in Omnomcom',
                    'Complete purchase as cashier, payed with bank card.'
                ))
            }

            function purchaseInitiate(cashOrCard, message, title) {
                modals['purchase-modal'].show()
                doQrAuth(
                    document.querySelector('#purchase-modal .qrAuth'),
                    message,
                    purchase
                )
                cash = cashOrCard[0]
                bankCard = cashOrCard[1]
                modalStatus = 'purchase'
                document.getElementById('purchase-modal h1').innerHTML = title
                if (bankCard) document.getElementById('purchase-bank-card').classList.add('modal-toggle-true')
            }


            /* Handle idle timeout */
            let idleTime = 0;
            let idleWarning = false;

            setInterval(timerIncrement, 1000) // 1 second

            // Reset idle timer on mouse movement.
            document.body.addEventListener('mousemove', _ => {
                idleTime = 0;
                idleWarning = false;
            })

            // Reset idle timer on keydown
            document.body.addEventListener('keydown', _ => {
                idleTime = 0
                idleWarning = false
            })

            // Called each minute
            function timerIncrement() {
                idleTime = idleTime + 1

                if (idleTime > 60 && !idleWarning) {
                    let anyThingInCart = false
                    for (let id in cart) if (cart[id] > 0) anyThingInCart = true

                    if (anyThingInCart && modals.every(el => el._isShown())) {
                        idleWarning = true
                        modals.forEach(el => el.hide())
                        modals['idlewarning-modal'].show()

                        setTimeout(_ => { if (idleWarning) window.location.reload() }, 10000)
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
