<html>
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>

    <script>
        var server = "{!! env('HERBERT_SERVER') !!}";
        var token = 0;

        $(document).ready(function() {
            $.ajax({
                url: "{!! env('APP_URL') !!}/api/token",
                dataType: "jsonp",
                success: function(_token) {

                    token = _token.token;

                    var errorElement = $("body");

                    var remote = io(server + '/protube-remote');

                    function focusOnPin() {
                        var input_flds = $('#pin-input').find(':input');

                        for(var i = 0; i < 3; i++) {
                            input_flds.eq(i).val('');
                        }
                        input_flds.eq(0).focus();
                    }

                    remote.on("connect", function() {
                        $("#connecting").hide(0);
                        $("#connected").show(0);
                        if(token) remote.emit("token", token);

                        focusOnPin();
                    });

                    $('#login').click(function(){
                        focusOnPin();
                    });

                    remote.on("reconnect", function() {
                        location.reload();
                    });

                    remote.on("disconnect", function() {
                        location.reload();
                    });

                    remote.on("queue", function(data) {
                        var queue = $("#queue");
                        queue.html("");

                        for(var i in data) {
                            queue.append('<img src="http://img.youtube.com/vi/' + data[i].id + '/0.jpg" />');
                        }
                    });

                    $('form').bind('submit', function(e){
                        e.preventDefault();
                        remote.emit("search", $("#searchBox").val());
                        $("#results").html("Loading...");
                    });

                    $(".pin").keyup(function(e) {
                        console.log('log');

                        var input_flds = $('#pin-input').find(':input');

                        if(e.keyCode == 8 && input_flds.index(this) > 0) {
                            input_flds.eq(input_flds.index(this) - 1).focus();
                        }
                        else if($(this).val().length == 1) {
                            input_flds.eq(input_flds.index(this) + 1).focus();
                        }
                        else if($(this).val().length > 1) {
                            $(this).val($(this).val()[0]);
                        }

                        if(input_flds.index(this) >= 2) {
                            var pincode = '';
                            for(var i = 0; i < 3; i++) {
                                pincode += input_flds.eq(i).val().toString();
                            }
                            remote.emit("authenticate", { 'pin' : pincode });
                        }
                    });

                    $('body').on('keydown', function(event){
                        if( $('#login').is(':visible') ) {
                            if(event.keyCode >= 48 && event.keyCode <= 57 ) { // 0-9 normal
                                $('.keyboard-key:contains("' + (event.keyCode - 48) + '")').click();
                            } else if(event.keyCode >= 96 && event.keyCode <= 105 ) { // 0-9 normal
                                $('.keyboard-key:contains("' + (event.keyCode - 96) + '")').click();
                            } else if( event.keyCode == 8 ) { // backspace
                                $('.keyboard-key.back').click();
                            }
                        }
                    });

                    remote.on("authenticated", function(correct) {
                        if(correct) {
                            $("#login").hide(0);
                            $("#loggedIn").show(0);
                        }
                        else{
                            $("#pin-input").css({
                                "animation": "shake 0.82s cubic-bezier(.36,.07,.19,.97) both"
                            });

                            setTimeout(function() {
                                $("#pin-input").css({
                                    "animation": "none"
                                });
                            }, 1000);

                            focusOnPin();
                        }
                    });

                    remote.on("searchResults", function(data) {
                        var results = $("#results");

                        results.html("");

                        for(var i in data) {
                            results.append(generateResult(data[i]));
                        }

                        $(".result").each(function(i) {
                            var current = $(this);
                            current.click(function(e) {
                                e.preventDefault();
                                console.log({
                                    id: current.attr("ytId"),
                                    showVideo: ($("#showVideo").prop("checked") ? true : false)
                                });
                                remote.emit("add", {
                                    id: current.attr("ytId"),
                                    showVideo: ($("#showVideo").prop("checked") ? true : false)
                                });
                            })
                        });
                    });


                }
            });
        });

        function generateResult(item) {
            var result = '<div class="result" ytId="' + item.id + '">' +
                    '<img src="http://img.youtube.com/vi/' + item.id + '/0.jpg" />' +
                    '<div>' +
                    '<h1>' + item.title + '</h1>' +
                    '<h2>' + item.channelTitle +  '</h2>' +
                    '<h3>' + item.duration + '</h3>' +
                    '</div>' +
                    '<div style="clear: both;"></div>' +
                    '</div>';

            return result;
        }
    </script>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />

    <style>
        @import url("https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900,900italic,300italic,300,100italic,100");

        body {
            background-color: #111;
            color: #fff;
            margin: 0;
            padding: 0;

            font-family: 'Roboto', sans-serif;
        }

        input[type=number] {
            padding: 10px;
            border: 1px solid #ddd;
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 30px;
        }

        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }

        #pin-input {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            display: block;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        @keyframes shake {
          10%, 90% {
            transform: translate3d(-2px, 0, 0);
          }

          20%, 80% {
            transform: translate3d(4px, 0, 0);
          }

          30%, 50%, 70% {
            transform: translate3d(-8px, 0, 0);
          }

          40%, 60% {
            transform: translate3d(8px, 0, 0);
          }
        }

        input {
            background-color: #000;
            color: #fff;
            border: #c3ff00 1px solid;
            font-size: 16px;
            padding: 20px;
        }

        button {
            background-color: #000;
            color: #fff;
            border: #c3ff00 1px solid;
            font-size: 16px;
            padding: 20px;
            width: 100%;
        }

        #connecting {
            display: block;
        }

        #connected {
            display: none;
        }

        #queue {
            position: absolute;
            top: 0;
            left: 0px;
            right: 0px;
            height: 100px;
        }

        #queue img {
            height: 100px;
        }

        #login {
            display: table;
            position: absolute;
            height: 100%;
            width: 100%;
        }

        .input-box {
            display: table-cell;
            vertical-align: middle;
        }

        #loggedIn {
            display: none;
        }

        #results {
            position: absolute;
            top: 75px;

            width: 100%;
        }

        .result {
            position: relative;
            background-color: #222;
            margin-bottom: 10px;
            cursor: pointer;
            height: 180px;
        }

        .result > div {
            position: absolute;
            top: 0;
            left: 240px;
            right: 0;

            padding: 25px;
        }

        .result > div > h1 {
            font-size: 14px;
            margin: 0 0 5px;
            padding: 0 0 0 15px;
        }

        .result > div > h2 {
            font-size: 10px;
            margin: 0 0 5px;
            padding: 0 0 0 15px;
        }

        .result > div > h3 {
            font-weight: 300;
            font-size: 10px;
            margin: 0 0 5px;
            padding: 0 0 0 15px;
        }

        .result img {
            position: absolute;
            top: 0;
            left: 0;

            width: 240px;
            height: 180px;
        }

        .result:hover {
            background-color: #444;
        }
    </style>

    <title>Remote</title>
    
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-36196842-5', 'auto');
        ga('send', 'pageview');

    </script>

</head>

<body>

<div id="connecting">
    Connecting...
</div>

<div id="connected">
    <div id="login">
        <section class="input-box">
            <form id="pin-input">
                <input name="pin-a" class="pin pin--a" type="number" pattern="[0-9]*" inputmode="numeric" maxlength="1" />
                <input name="pin-b" class="pin pin--b" type="number" pattern="[0-9]*" inputmode="numeric" maxlength="1" />
                <input name="pin-c" class="pin pin--c" type="number" pattern="[0-9]*" inputmode="numeric" maxlength="1" />
            </form>
        </section>

    </div>

    <div id="loggedIn">
        <div id="search">
            <form action="" method="get">
                <table width="100%">
                    <tr>
                        <td><input type="text" id="searchBox" placeholder="Search" autocomplete="off" style="width: 100%;" /></td>
                        <td style="width: 130px; text-align: right;"><label for="showVideo">Show video</label> <input type="checkbox" checked="checked" id="showVideo" /></td>
                    </tr>
                </table>
            </form>
            <div id="results">
                <!-- Filled by JS -->
            </div>
        </div>
    </div>
</div>

</body>
</html>
