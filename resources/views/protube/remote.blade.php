<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>

    <script>
        var server = "{!! env('HERBERT_SERVER') !!}";
        @if(Auth::check()) var token = "{!! Session::get('token') !!}"; @else var token; @endif

        $(document).ready(function() {
            var errorElement = $("body");

            var remote = io(server + '/protube-remote');

            remote.on("connect", function() {
                $("#connecting").hide(0);
                $("#connected").show(0);
                if(token) remote.emit("token", token);
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

            $("#pincode").html("");

            $('.keyboard-key').on('click', function(){
                errorElement.css({
                    "-moz-animation": "none",
                    "-webkit-animation": "none",
                    "animation": "none"
                });

                var pincode = $("#pincode");

                if($(this).hasClass('back')) {
                    pincode.html( pincode.html().substring(0, pincode.html().length-1) );
                } else {
                    if(pincode.html().length < 3) {
                        pincode.html( pincode.html() + $(this).html() );
                    }
                }

                if( pincode.html().length == 3 ) {
                    remote.emit("authenticate", { 'pin' : pincode.html() });
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
                }else{
                    $(errorElement).css({
                        "-moz-animation": "error 0.5s",
                        "-webkit-animation": "error 0.5s",
                        "animation": "error 0.5s"
                    });
                    $("#pincode").html("");
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
            display: block;
            width: 100%;
            margin-top: 120px;
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

        /*** Keypad ***/
        #keypad {
            display: none;
        }

        #keypad p {
            text-align: center;
            color: #FFFFFF;
            font-size: 14px;
            margin: 20px 0;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.5);
        }

        #pincode {
            text-align: center;
            color: #FFFFFF;
            font-size: 20px;
            background: #222;
            box-shadow: inset 1px 1px 1px #000;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
            padding: 5px 0;
            width: 186px !important;
            margin: 10px auto 20px auto;
            height: 25px;
            line-height: 25px;
        }

        .keyboard-row {
            overflow: hidden;
            width: 196px;
            margin: 10px auto;
        }

        .keyboard-key {
            padding: 0 20px;
            background: #474747;
            border-top: 1px solid #858585;
            border-bottom: 1px solid #343434;
            border-left: 1px solid #424242;
            border-right: 1px solid #424242;
            margin: 0 5px;
            color: #FFF;
            cursor: pointer;
            text-shadow: 0 1px 1px rgba(0,0,0,0.3);
            float: left;
            width: 13px;
            height: 45px;
            line-height: 45px;
            text-align: center;
            font-size: 14px;
        }

        .keyboard-key:first-child:last-child {
            margin-left: 70px;
        }

        .keyboard-key:hover {
            -webkit-animation: touched 0.5s;
            -moz-animation: touched 0.5s;
            animation: touched 0.5s;
        }

        .keyboard-key.invisible {
            visibility: hidden;
        }

        .keyboard-key.back {
            background-image: url("http://protube.saproto.nl/remote/img/backspace.png");
            background-repeat: no-repeat;
            background-position: center center;
        }

        @-webkit-keyframes touched {
            0%, 100%  {
                background-color: #474747;
            }
            10% {
                background-color: #9C0;
            }
        }

        @-moz-keyframes touched {
            0%, 100% {
                background-color: #474747;
            }
            10% {
                background-color: #9C0;
            }
        }

        @keyframes touched {
            0%, 100% {
                background-color: #474747;
            }
            10% {
                background-color: #9C0;
            }
        }

        @-moz-keyframes error {
            0%,
            100% { background: #111; }
            10% { background: #C00; }
        }

        @-webkit-keyframes error {
            0%,
            100% { background: #111; }
            10% { background: #C00; }
        }

        @keyframes error {
            0%,
            100% { background: #111; }
            10% { background: #C00; }
        }
    </style>

    <title>Remote</title>
</head>

<body>

<div id="connecting">
    Connecting...
</div>

<div id="connected">
    <div id="login">
        <div id="pincode">
            <!-- Filled by JS -->
        </div>
        <div class="keyboard-row">
            <div class="keyboard-key">7</div>
            <div class="keyboard-key">8</div>
            <div class="keyboard-key">9</div>
        </div>
        <div class="keyboard-row">
            <div class="keyboard-key">4</div>
            <div class="keyboard-key">5</div>
            <div class="keyboard-key">6</div>
        </div>
        <div class="keyboard-row">
            <div class="keyboard-key">1</div>
            <div class="keyboard-key">2</div>
            <div class="keyboard-key">3</div>
        </div>
        <div class="keyboard-row">
            <div class="keyboard-key invisible"></div>
            <div class="keyboard-key">0</div>
            <div class="keyboard-key back"></div>
        </div>
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