<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>OmNomCom Store</title>

    <style type="text/css">

        @import url(https://fonts.googleapis.com/css?family=Lato);

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

            font-size: 20px;

            color: #333;

            background-color: #C1FF00;

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
        }

        .category_view.inactive {
            transform: translate(0, -100%);
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
        }

        .product-price {
            position: absolute;

            bottom: 10px;
            left: -50px;
            padding: 10px;

            color: #333;

            font-weight: bold;

            background-color: #C1FF00;
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

            background-color: #C1FF00;
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

            border: 10px solid #C1FF00;
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

            background-color: #C1FF00;
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

</div>

<div id="product_nav">

    @foreach($categories as $category)

        <div class="category_view {{ ($category == $categories[0] ? '' : 'inactive') }}"
             data-id="{{ $category->category->id }}">

            @foreach($category->products as $product)

                @if($product->isVisible())

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

                                <div class="product-stock">
                                    {{ $product->stock }} x
                                </div>

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    @endforeach

</div>

<div id="controls">

    <div id="buttons">

    </div>

    <div id="cart">

    </div>

</div>

@section('javascript')
    @include('website.layouts.assets.javascripts')
@show

<script type="text/javascript">

    var images = [];
    var cart = [];
    var stock = [];

    @foreach($categories as $category)
            @foreach($category->products as $product)
            @if($product->isVisible() && $product->image)
            images[{{ $product->id }}] = '{!! $product->image->generateImagePath(100, null) !!}';
    cart[{{ $product->id }}] = 0;
    stock[{{ $product->id }}] = {{ $product->stock }};
    @endif
    @endforeach
    @endforeach

$('.category_button').on('click', function () {
        $('.category_button').addClass('inactive');
        $('.category_button[data-id=' + $(this).attr('data-id') + ']').removeClass('inactive');
        $('.category_view').addClass('inactive');
        $('.category_view[data-id=' + $(this).attr('data-id') + ']').removeClass('inactive');
    });

    $('.product').on('click', function () {

        if (stock[$(this).attr('data-id')] <= 0) {
            alert('This product is out of stock!');
        } else {

            cart[$(this).attr('data-id')]++;
            stock[$(this).attr('data-id')]--;

            $('.product[data-id=' + $(this).attr('data-id') + '] .product-stock').html(stock[$(this).attr('data-id')] + ' x');

            update();

        }

    })

    $('#cart').delegate('.cart-product', 'click', function () {

        cart[$(this).attr('data-id')]--;
        stock[$(this).attr('data-id')]++;

        $('.product[data-id=' + $(this).attr('data-id') + '] .product-stock').html(stock[$(this).attr('data-id')] + ' x');

        update();

    });

    function update() {
        $("#cart").html("");
        for (id in cart) {
            if (cart[id] > 0) {
                $("#cart").append('<div class="cart-product" data-id="' + id + '"><div class="cart-product-image"><div class="cart-product-image-inner" style="background-image: url(\'' + images[id] + '\');"></div></div><div class="cart-product-count">' + cart[id] + 'x</div></div>');
            }
        }
    }

</script>

</body>

</html>