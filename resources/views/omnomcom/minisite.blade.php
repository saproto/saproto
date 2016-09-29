<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>

    <meta name="viewport" content="width=900px, user-scalable=no">

    <title>OmNomCom Inventory Viewer</title>

    <meta name="theme-color" content="#0089FA">

    <meta property="og:type" content="website"/>
    <meta property="og:title" content="OmNomCom Inventory Viewer"/>
    <meta property="og:description"
          content="The OmNomCom Inventory Viewer can tell you if your favourite nom is available in the Protopolis. Give it a try!"/>
    <meta property="og:url" content="https://www.omnomcom.nl/"/>
    <meta property="og:image" content="{{ asset('images/subsites/omnomcom.jpg') }}"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $("#search_query").keyup(function () {
                var query = $("#search_query").val();
                if (query.length < 2) {
                    $(".result").hide().removeClass("result_left");
                } else {
                    $(".result").hide().removeClass("result_left");
                    var c = 1;
                    $("#results .result").each(function () {

                        var name = $(this).find('.result_name').first().html().toLowerCase().replace(/[^a-zA-Z0-9]/g, '');
                        var category = $(this).find('.result_category').first().html().toLowerCase().replace(/[^a-zA-Z0-9]/g, '');
                        var querymod = query.toLowerCase().replace(/[^a-zA-Z0-9]/g, '');
                        if (name.indexOf(querymod) > -1 || category.indexOf(querymod) > -1) {
                            $(this).show();
                            if (c % 2 == 1) {
                                $(this).addClass("result_left");
                            }
                            c++;
                        }

                    });
                }
            });
        });

    </script>
    <style type="text/css">
        body {
            background-color: #0089FA;
            font-family: "Roboto Slab", "Arial";
            color: #fff;
        }

        .animate {
            transition: all 0.5s;
            -o-transition: all 0.5s;
            -moz-transition: all 0.5s;
            -webkit-transition: all 0.5s;
        }

        #mainscreen {
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
        }

        #mainscreen {
            text-align: center;
            color: #fff;
            font-size: 50px;
            padding-top: 100px;
            font-weight: 700;
        }

        #search_query {
            background-color: #fff;
            font-size: 30px;
            padding: 20px;
            color: #0089FA;
            font-family: "Roboto Slab", "Arial";
            border: none;
            margin-top: 20px;
            width: 800px;
        }

        #results {
            margin: 50px auto 100px auto;
            width: 800px;
            overflow: auto;
        }

        .result {
            background-color: #fff;
            color: #000;
            width: 390px;
            height: 200px;
            margin-bottom: 20px;
            float: left;
            display: none;
            font-weight: 400;
            font-size: 25px;
        }

        .result.unavailable {
            opacity: 0.5;
        }

        .result_left {
            margin-right: 20px;
        }

        .result_image, .result_info {
            width: 235px;
            height: 200px;
            float: left;
        }

        .result_image {
            width: 115px;
            height: 160px;
            margin: 20px;
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .result_name {
            background-color: #0089FA;
            color: #fff;
            padding: 5px;
            margin: 10px;
            font-size: 20px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .result_price, .result_amount {
            width: 100px;
            height: 100px;
            float: left;
        }

        .result_price {
            margin-right: 15px;
            margin-left: 10px;
        }

        .result_title {
            background-color: rgba(0, 0, 0, 0.1);
            padding: 10px 0px;
            text-align: center;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .result_category {
            float: left;
            background-color: rgba(0, 0, 0, 0.1);
            padding: 6px 0px;
            text-align: center;
            font-size: 15px;
            margin: 0px 10px;
            width: 215px;
        }
    </style>
</head>
<body>
<div id="mainscreen" class="animate">
    What would you like to eat?<br>
    <input type="text" id="search_query">
    <div id="results">
        @foreach(Product::where('is_visible_when_no_stock', true)->where('is_visible', true)->get() as $i => $product)

            @if(count(array_intersect($product->categories->pluck('id')->toArray(), config('omnomcom.stores')['protopolis']->categories)) > 0)

                <div class='result {{ ($product->stock <= 0 ? 'unavailable' : '') }}'>
                    <div class='result_image'
                         @if($product->image)
                         style='background-image:url("{{ $product->image->generateImagePath(400,null) }}")'
                            @endif
                    ></div>
                    <div class='result_info'>
                        <div class='result_name'>{{ $product->name }}</div>
                        <div class='result_price'>
                            <div class='result_title'>Price</div>
                            <div class='result_data'>&euro;{{ number_format($product->price, 2, '.', ',') }}</div>
                        </div>
                        <div class='result_amount'>
                            <div class='result_title'>Available</div>
                            <div class='result_data'>{{ $product->stock }}</div>
                        </div>
                        <div class='result_category'>{{ implode(", ", $product->categories->pluck('name')->toArray()) }}</div>
                    </div>
                </div>

            @endif

        @endforeach
    </div>

    <a href="https://www.proto.utwente.nl/">
        <img src="{{ asset('images/logo/inverse.png') }}" style="width: 400px;">
    </a>

</div>

</body>
</html>