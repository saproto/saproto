<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>ProTube remote</title>

    @include('website.layouts.assets.stylesheets')

    <style type="text/css">
        body, html {
            margin: 0;
            padding: 0;

            background-color: #fff;
        }

        #connecting {
            position: absolute;
            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            background-color: #7FBA00;

            z-index: 1000;

            display: table;
        }

        #connecting > div {
            display: table-cell;
            vertical-align: middle;

            font-size: 24px;
            font-weight: bold;

            color: #fff;

            text-align: center;
        }

        #protube__remote__login__table {
            display: table;

            position: absolute;
            top: 0;
            left: 0;

            height: 100%;
            width: 100%;
        }

        .protube__remote__loginHeader {
            background-color: #7FBA00;

            position: absolute;
            top: 0;
            left: 0;

            width: 100%;
            height: calc(50% - 80px)
        }

        #protube__remote__login__photo {
            width: 250px;
            border: 10px solid white;
            border-radius: 50%;
            text-align: center;
            background-color: #7FBA00;
        }

        #protube__remote__login__status {
            text-align: center;

            font-size: 24px;

            margin: 25px;
        }

        .protube__remote__login__hint {
            font-size: 14px;
            font-weight: lighter;

            color: #aaa;

            margin-top: 20px;
        }

        .input-box {
            display: table-cell;
            vertical-align: middle;
        }

        #protube__remote__loggedIn {
            display: none;
        }

        #protube__remote__nav .btn {
            border: 0;
        }

        #protube__remote__nav input {
            border: 0;
        }

        #protube__remote__showToggle {
            font-size: 25px;
            vertical-align: middle;
            line-height: 36px;

            text-align: right;
        }

        #protube__remote__userModal .modal-content {
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            position: relative;
        }

        #protube__remote__userModal .color-overlay {
            position: absolute;
            top: 0;
            left: 0;

            border-top-left-radius: 10px;
            border-top-right-radius: 10px;

            width: 100%;
            height: 175px;

            background-color: #7FBA00;
        }

        #protube__remote__userModal__photo {
            width: 250px;
            border: 10px solid white;
            border-radius: 50%;
            text-align: center;
            background-color: #7FBA00;
        }

        #protube__remote__userModal h1 {
            font-size: 35px;

            margin: 0;
            padding: 0;
        }

        #protube__remote__userModal h2 {
            font-size: 16px;
            font-weight: lighter;

            padding: 0;

            margin: 10px 0 0;
        }

        #protube__remote__userModal__infoList {
            margin-top: 20px;
        }

        .protube__remote__searchReults__heading {
            font-size: 18px;
            font-weight: bold;
            padding-left: 20px;
            padding-right: 20px;
        }

        #protube__remote__searchResults {
            margin-bottom: 70px;
        }

        .protube__remote__searchResults__result {
            border: solid 1px #ccc;
            padding: 0;
            position: relative;
        }

        .protube__remote__searchResults__resultContainer {
            padding: 10px;
        }

        .protube__remote__searchResults__result .result_details {
            background-color: #fff;
            padding: 10px;
        }

        .protube__remote__searchResults__result .result_details p {
            margin: 0;
            padding: 0;
        }

        .protube__remote__searchResults__result .image__container {
            position: relative;
        }

        .protube__remote__searchResults__result .image__container img {
            width: 100%;
        }

        .protube__remote__searchResults__result .image__container h1 {
            font-size: 18px;
            font-weight: normal;
            margin: 0;
            padding: 0;

            position: absolute;
            bottom: 10px;
            left: 10px;

            color: #f0f0f0;

            text-shadow: #000 0px 0px 2px;
        }

        .protube__remote__searchResults__result .addButton {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            position: absolute;
            bottom: 50px;
            right: 20px;

            color: #fff;
            background-color: #FDBE2E;

            vertical-align: middle;
            text-align: center;

            font-size: 32px;

            box-shadow: 0 2px 10px 2px rgba(0, 0, 0, 0.3);

            -webkit-transition: .4s;
            transition: .4s;

            cursor: pointer;
        }

        .protube__remote__searchResults__result .addButton.added {
            background-color: #7FBA00;
        }

        .protube__remote__searchResults__result .addButton:hover {
            transform: scale(1.1);
        }

        .protube__remote__queue {
            background-color: #111;

            position: fixed;
            bottom: 0;
            left: 0;

            width: 100%;

            text-align: right;
        }

        #protube__remote__queue__container {
            text-align: left;
            overflow: hidden;

            height: 105px;

            white-space: nowrap;
        }

        .protube__remote__queue .queueSong {
            display: inline-block;
            height: 105px;

            position: relative;
        }

        .protube__remote__queue .queueSong img {
            width: 170px;
            height: 135px;

            margin-top: -15px;
            margin-bottom: -15px;
        }

        .protube__remote__queue .queueSong p {
            margin: 0;
            padding: 5px;

            width: 100%;

            position: absolute;

            bottom: 0;
            left: 0;

            color: #fff;

            background-color: rgba(0, 0, 0, 0.4);

            font-size: 12px;

            text-overflow: ellipsis;
            overflow: hidden;
        }

        .protube__remote__queue_nowPlaying {
            padding: 10px;

            width: 100%;
            height: 45px;

            position: relative;
        }

        #protube__remote__queue_nowPlaying_container {
            position: absolute;
            top: 10px;
            left: 10px;

            text-align: left;

            float: left;
            padding-bottom: 10px;

            color: #fff;

            z-index: 20;

            text-overflow: ellipsis;
            overflow: hidden;

            width: 100%;
            height: 20px;
            white-space: nowrap;
        }

        .protube__remote__queue_nowPlaying_button {
            float: right;

            color: #ccc;

            z-index: 20;
        }

        #protube__remote__queue_nowPlaying_progress {
            position: absolute;
            top: 0;
            left: 0;

            width: 0%;
            height: 45px;

            background-color: #7FBA00;

            z-index: 10;

            animation-timing-function: linear;
        }

        .nowPlayingIcon {
            position: absolute;
            top: 0;
            left: 0;

            color: #fff;

            font-size: 75px;

            width: 100%;
            height: 100%;

            text-align: center;
            vertical-align: middle;

            z-index: 100;
        }

        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 80px;
            height: 34px;
            vertical-align: middle;
        }

        /* Hide default HTML checkbox */
        .switch input {
            display: none;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        input:checked + .slider {
            background-color: #fff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #000;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(45px);
            -ms-transform: translateX(45px);
            transform: translateX(45px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        @media (min-width: 768px) {
            .row.vertical-align {
                display: flex;
                align-items: center;
            }

            #protube__remote__searchResults {
                margin-top: 80px;
            }
        }

        @media (max-width: 767px) {
            #protube__remote__showToggle {
                margin-bottom: 5px;
            }

            #protube__remote__searchResults {
                margin-top: 120px;
            }

            #protube__remote__showToggle {
                text-align: left;
            }
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

        input[type=number] {
            -moz-appearance: textfield;
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
    </style>

</head>

<body>

<div id="connecting">
    <div>Connecting...</div>
</div>

<div id="protube__remote__login">
    <div class="protube__remote__loginHeader"></div>

    <div id="protube__remote__login__table">
        <section class="input-box" style="text-align: center;">
            <img id="protube__remote__login__photo" src="{{ asset('images/protube/incognito.png') }}"
                 alt="Profile picture">
            <h2 id="protube__remote__login__status"><strong>You are not logged in</strong> <br/> <a
                        class="btn btn-default" href="{{ env('APP_URL') . route('protube::login', array(), false)  }}"
                        data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Logging in will keep your personal ProTube history, and will show other members you entered a song into the queue.">Login</a>
            </h2>
            <form id="pin-input">
                <input name="pin-a" class="pin pin--a" type="number" pattern="[0-9]*" inputmode="numeric"
                       maxlength="1"/>
                <input name="pin-b" class="pin pin--b" type="number" pattern="[0-9]*" inputmode="numeric"
                       maxlength="1"/>
                <input name="pin-c" class="pin pin--c" type="number" pattern="[0-9]*" inputmode="numeric"
                       maxlength="1"/>
            </form>
            <div class="protube__remote__login__hint">(enter the pin from the ProTube screen)</div>
        </section>
    </div>
</div>

<div id="protube__remote__loggedIn">

    <nav class="navbar navbar-dark fixed-top bg-primary text-white justify-content-center align-items-center"
         id="protube__remote__nav">

        <div class="container row">

            <div class="col-md-8 col-12 justify-content-center">

                <form id="protube__remote__ytSearch_form">
                    <input type="search" id="protube__remote__ytSearch"
                           class="form-control" placeholder="Search on Youtube (maximum duration {{ $max_duration }})..."
                           style="width: 100%;">
                </form>

                <sub>
                    <i class="fas fa-bolt me-1"></i>
                    Developed with
                    <span class="text-danger"><i class="fab fa-youtube fa-fw"></i> YouTube</span>
                </sub>

            </div>

            <div class="col-md-3 col-6">

                <div class="text-left" id="protube__remote__showToggle">
                    <i class="fas fa-images" aria-hidden="true"></i>

                    <label class="switch mb-0">
                        <input type="checkbox" id="protube__remote__videoToggle" checked>
                        <span class="slider round"></span>
                    </label>

                    <i class="fab fa-youtube" aria-hidden="true"></i>
                </div>

            </div>

            <div class="col-md-1 col-6 text-start">

                <img class="rounded-circle" data-bs-toggle="modal" id="protube__remote__profilePic"
                     data-bs-target="#protube__remote__userModal" src="{{ asset('images/protube/incognito.png') }}"
                     alt="Profile picture" style="border: 2px solid #fff; height: 40px; width: 40px;">

            </div>

        </div>

    </nav>

    <div class="container" id="protube__remote__searchResults">
        <div class="row" id="protube__remote__searchResults_row">
        </div>
    </div>

    <div class="protube__remote__queue">
        <div class="protube__remote__queue_nowPlaying" data-bs-toggle="collapse" href="#protube__remote__queue__container">
            <div id="protube__remote__queue_nowPlaying_progress"></div>

            <div id="protube__remote__queue_nowPlaying_container">

            </div>
            <div class="protube__remote__queue_nowPlaying_button"><i class="fas fa-ellipsis-h" aria-hidden="true"></i>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="collapse in" id="protube__remote__queue__container">

        </div>
    </div>

</div>

<div class="modal fade" id="protube__remote__userModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="color-overlay"></div>

            <div class="modal-body" style="text-align: center;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="protube__remote__userModal__photo" src="{{ asset('images/protube/incognito.png') }}"
                     alt="Profile picture">
                <h2 id="protube__remote__userModal__status">You are not logged in</h2>
                <h1 id="protube__remote__userModal__name"></h1>

                <div class="list-group" id="protube__remote__userModal__infoList">
                    <a href="{{ route("login::show") }}" class="list-group-item">
                        <i class="fas fa-sign-in" aria-hidden="true"></i>
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('website.layouts.assets.javascripts')
@stack('javascript')

<script>
    $(document).ready(function () {
        if ($(window).width() <= 768) {
            $('.collapse').removeClass('in');
        }
    });

    $(window).resize(function () {
        if ($(window).width() >= 768) {
            $('.collapse').addClass('in');
        }
        if ($(window).width() <= 768) {
            $('.collapse').removeClass('in');
        }
    });

    var server = "{!! config('herbert.server') !!}";
    var token = 0;

    var userInfo = {};

    var currentDuration = 0;

    function setProgressBar(duration, progress) {
        var current = progress;
        var total = duration;

        currentDuration = duration;

        var progressBar = $("#protube__remote__queue_nowPlaying_progress");
        var percentage = current / total * 100;

        stopProgressBar(true);

        progressBar.css({
            width: percentage + '%'
        });

        progressBar.animate({
            width: '100%'
        }, (total - current) * 1000, 'linear', function () {
            $(this).css({
                width: '0%'
            });
        });
    }

    function stopProgressBar(reset) {
        var progressBar = $("#protube__remote__queue_nowPlaying_progress");

        progressBar.stop();
        if (reset) progressBar.css({width: '0'});
    }

    $(document).ready(function () {
        $.ajax({
            url: "{!! config('app-proto.app-url') !!}/api/token",
            dataType: "jsonp",
            success: function (_token) {

                userInfo = _token;

                token = _token.token;

                var errorElement = $("body");

                var remote = io(server + '/protube-remote');

                function focusOnPin() {
                    var input_flds = $('#pin-input').find(':input');
                    for (var i = 0; i < 3; i++) {
                        input_flds.eq(i).val('');
                    }
                    input_flds.eq(0).focus();
                }

                remote.on("connect", function () {
                    $("#connecting").fadeOut(500);

                    if (token) {
                        remote.emit("token", token);
                        $("#protube__remote__userModal__name").html(userInfo.name);
                        $("#protube__remote__userModal__status").html("You are logged in");
                        $("#protube__remote__login__status").html("Welcome back, <br /> <strong>" + userInfo.name + "</strong>");
                        $("#protube__remote__userModal__photo").attr("src", userInfo.photo);
                        $("#protube__remote__login__photo").attr("src", userInfo.photo);
                        $("#protube__remote__profilePic").attr("src", userInfo.photo);
                        $("#protube__remote__userModal__infoList").html("<a href=\"{{ route("protube::dashboard") }}\" target=\"_blank\" class=\"list-group-item\">\n" +
                            "                        <i class=\"fas fa-user-secret\" aria-hidden=\"true\"></i>\n\n\n" +
                            "                        Privacy settings</a>\n" +
                            "                    <a href=\"{{ route("login::logout") }}\" class=\"list-group-item\">\n" +
                            "                        <i class=\"fas fa-sign-out\" aria-hidden=\"true\"></i>\n" +
                            "                        Logout\n" +
                            "                    </a>")
                    }

                    var pincode = window.location.href.split('/');
                    pincode = pincode[pincode.length - 1];
                    if (pincode.length == 3) {
                        remote.emit("authenticate", {"pin": pincode});
                    }

                    focusOnPin();

                });

                $(".pin").keyup(function (e) {
                    console.log('log');
                    var input_flds = $('#pin-input').find(':input');
                    if (e.keyCode == 8 && input_flds.index(this) > 0) {
                        input_flds.eq(input_flds.index(this) - 1).focus();
                    }
                    else if ($(this).val().length == 1) {
                        input_flds.eq(input_flds.index(this) + 1).focus();
                    }
                    else if ($(this).val().length > 1) {
                        $(this).val($(this).val()[0]);
                    }
                    if (input_flds.index(this) >= 2) {
                        var pincode = '';
                        for (var i = 0; i < 3; i++) {
                            pincode += input_flds.eq(i).val().toString();
                        }
                        remote.emit("authenticate", {'pin': pincode});
                    }
                });

                $('#protube__remote__login').click(function () {
                    focusOnPin();
                });

                remote.on("reconnect", function () {
                    location.reload();
                });

                remote.on("disconnect", function () {
                    location.reload();
                });

                remote.on("queue", function (data) {
                    var queue = $("#protube__remote__queue__container");

                    console.log(data);

                    queue.html("");

                    for (var i in data) {
                        queue.append("<div class=\"queueSong\">\n" +
                            "                <img src=\"https://img.youtube.com/vi/" + data[i].id + "/0.jpg\">\n" +
                            "                <p>" + data[i].title + "</p>\n" +
                            "            </div>");
                    }
                });

                remote.on("ytInfo", function (data) {
                    var nowplaying = $("#protube__remote__queue_nowPlaying_container");

                    if (!$.isEmptyObject(data)) {
                        if (data.showVideo) {
                            var nowplaying_icon = "<i class=\"fab fa-youtube\" aria-hidden=\"true\"></i>";
                        } else {
                            var nowplaying_icon = "<i class=\"fas fa-picture-o\" aria-hidden=\"true\"></i>";
                        }

                        nowplaying.html(nowplaying_icon + " " + data.title);

                        setProgressBar(data.duration, data.progress);
                    } else {
                        nowplaying.html("<i class=\"fas fa-music\" aria-hidden=\"true\"></i> Now playing radio");
                        stopProgressBar(true);
                    }
                });

                remote.on("progress", function (data) {
                    console.log(data);
                    setProgressBar(currentDuration, data);
                });

                $('#protube__remote__ytSearch_form').bind('submit', function (e) {
                    e.preventDefault();
                    remote.emit("search", encodeURIComponent($("#protube__remote__ytSearch").val()));
                    $("#protube__remote__searchResults_row").html("<div style=\"text-align: center; font-size: 24px; margin: 25px; width: 100%;\"><i class=\"fas fa-spinner fa-pulse fa-fw\"></i><br />\n" +
                        "Loading...</div>");
                    window.scrollTo(0, 0);
                });

                $('#protube__remote__pin_form').bind('submit', function (e) {
                    e.preventDefault();
                    remote.emit("authenticate", {'pin': $("#protube__remote__pin").val()});
                });


                $('body').on('keydown', function (event) {
                    if ($('#login').is(':visible')) {
                        if (event.keyCode >= 48 && event.keyCode <= 57) { // 0-9 normal
                            $('.keyboard-key:contains("' + (event.keyCode - 48) + '")').click();
                        } else if (event.keyCode >= 96 && event.keyCode <= 105) { // 0-9 normal
                            $('.keyboard-key:contains("' + (event.keyCode - 96) + '")').click();
                        } else if (event.keyCode == 8) { // backspace
                            $('.keyboard-key.back').click();
                        }
                    }
                });

                remote.on("authenticated", function (correct) {
                    if (correct) {
                        $("#protube__remote__login").hide(0);
                        $("#protube__remote__loggedIn").show(0);

                        $("#protube__remote__ytSearch").focus();

                        interactiveSearchResults();
                    }
                    else {
                        $("#pin-input").css({
                            "animation": "shake 0.82s cubic-bezier(.36,.07,.19,.97) both"
                        });

                        setTimeout(function () {
                            $("#pin-input").css({
                                "animation": "none"
                            });
                        }, 1000);
                    }
                });

                remote.on("searchResults", function (data) {
                    var results = $("#protube__remote__searchResults_row");

                    results.html("");

                    for (var i in data) {
                        results.append(generateResult(data[i]));
                    }

                    interactiveSearchResults();
                });

                function interactiveSearchResults() {
                    $(".protube__remote__searchResults__result").each(function (i) {
                        var current = $(this);
                        current.click(function (e) {
                            e.preventDefault();
                            console.log({
                                id: current.attr("data-ytId"),
                                showVideo: ($("#protube__remote__videoToggle").prop("checked") ? true : false)
                            });
                            remote.emit("add", {
                                id: current.attr("data-ytId"),
                                showVideo: ($("#protube__remote__videoToggle").prop("checked") ? true : false)
                            });
                            current.find(".addButton").addClass("added").html("<i class=\"fas fa-check\" aria-hidden=\"true\"></i>");

                        })
                    });
                }
            }
        });
    });

    function generateResult(item) {
        var result = '<div class="col-md-4 protube__remote__searchResults__resultContainer">' +
            '               <div class="protube__remote__searchResults__result" data-ytId="' + item.id + '">\n' +
            '                    <div class="image__container">\n' +
            '                        <img src="https://img.youtube.com/vi/' + item.id + '/0.jpg">\n' +
            '                        <h1>' + item.title + '</h1>\n' +
            '                    </div>\n' +
            '                    <div class="result_details">\n' +
            '                        <p><i class="fas fa-user" aria-hidden="true"></i> ' + item.channelTitle + '</p>\n' +
            '                        <p><i class="far fa-clock" aria-hidden="true"></i> ' + item.duration + '</p>\n' +
            '                    </div>\n' +
            '                    <div class="addButton">\n' +
            '                        <i class="fas fa-plus" aria-hidden="true"></i>\n' +
            '                    </div>\n' +
            '                </div>' +
            '           </div>';

        return result;
    }

    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

</script>

<!-- Matomo -->
<script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function () {
        var u = "//{{ config('proto.analytics_url') }}/";
        _paq.push(['setTrackerUrl', u + 'piwik.php']);
        _paq.push(['setSiteId', '3']);
        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
        g.type = 'text/javascript';
        g.async = true;
        g.defer = true;
        g.src = u + 'piwik.js';
        s.parentNode.insertBefore(g, s);
    })();
</script>
<!-- End Matomo Code -->

</body>

</html>
