<html>
<head>

    <script type="text/javascript" src="{{ asset('assets/application.min.js') }}"></script>

    <title>Screen</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900,900italic,300italic,300,100italic,100');

        html, body {
            width: 100%;
            heigth: 100%;

            margin: 0;
            padding: 0;

            background-color: #000;

            font-family: 'Roboto', sans-serif;
        }

        .inactive {
            z-index: 100000;

            position: absolute;
            top: 0;
            left: 0;

            font-size: 30px;

            width: 100%;
            height: 100%;

            background-color: #000;

            margin: 0;
            padding: 0;
        }

        .inactive p {
            position: absolute;
            top: 48%;
            left: 0;
            right: 0;

            text-align: center;

            margin: 0;
            padding: 0;

            color: #80B823;
        }

        #protubeOff {
            width: 100%;
            height: 100%;

            background-image: url('{{ asset('images/application/protube_offline.png') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;

            display: none;
        }

        #topBar {
            position: absolute;
            top: 0;
            left: 0;

            width: 100%;
            height: 35px;
        }

        #progressBar {
            position: absolute;
            bottom: 60px;
            left: 0;

            width: 0;
            height: 5px;

            background-color: #80B823;

            z-index: 500;
        }

        #progressBarBackground {
            position: absolute;
            bottom: 60px;
            left: 0;

            width: 100%;
            height: 5px;

            background-color: #222222;

            z-index: 400;
        }

        #playerContainer {
            position: absolute;
            top: 40px;
            bottom: 65px;
            left: 0;
            right: 0;
        }

        #nowPlaying {
            position: absolute;

            z-index: 9999;

            display: inline-block;
            left: 10px;
            top: 5px;

            color: #FFFFFF;
            font-size: 24px;
        }

        #addedBy {
            position: absolute;

            z-index: 9998;

            display: inline-block;
            right: 90px;
            top: 7px;

            color: #FFFFFF;
            font-size: 20px;
        }

        #player {

        }

        #bottomBar {
            position: absolute;

            bottom: 0;
            left: 0;

            width: 100%;
            height: 65px;

            overflow: hidden;

            z-index: 100;
        }

        .blackBg {
            background-color: #000;
        }

        #pin {
            position: absolute;

            bottom: 0;
            left: 0;

            width: 100px;
            height: 45px;
            text-align: center;

            margin: 0;
            padding: 0;

            background-color: rgba(0, 0, 0, 0.5);
        }

        #pin h1 {
            color: #80B823;
            font-size: 10px;

            margin: 0;
            padding: 0;

            margin-top: -10px;
        }

        #pin p {
            color: #fff;
            font-size: 42px;

            margin: 0;
            padding: 0;

            margin-top: -10px;
        }

        #queue {
            position: absolute;
            bottom: 0;
            left: 100px;
            right: -3000px;

            height: 60px;

            overflow: hidden;
        }

        #queue ul {
            position: relative;
            padding: 0;
            margin: 0;
        }

        #queue ul li {
            position: relative;
            width: 220px;
            height: 60px;
            display: inline-block;
            overflow: hidden;
            padding: 0;
            margin: 0;
        }

        #queue ul li h1 {
            position: absolute;
            top: 5px;
            left: 10px;
            width: 200px;
            height: 45px;
            font-size: 18px;
            font-weight: normal;
            color: #fff;
            text-shadow: #000 1px 1px;
            margin: 0;
            padding: 0;

            text-overflow: ellipsis;
            overflow: hidden;
        }

        #queue img {
            position: absolute;
            top: 0;
            left: 0;
            margin: -25px;
            height: 110px;
            width: 250px;
            filter: blur(7px) contrast(115%) brightness(80%);
        }

        #clock {
            position: absolute;

            top: 0;
            right: 0;

            padding: 4px 10px;

            z-index: 9999;

            background-color: #80B823;
            color: #000;

            font-size: 24px;

            text-align: center;
        }

        #slideshow {
            position: absolute;
            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            display: none;

            z-index: 50;
        }
    </style>

    <script>
        var server = "{!! config('herbert.server') !!}";

        var soundboardSounds;
        var soundboardVolume = 0;
        var soundboardPlayers = [];

        $.getJSON('{{ route('api::protube::sounds') }}', function(data) {
            soundboardSounds = data;

            for(var property in soundboardSounds) {
                $.ajax({ url: soundboardSounds[property].file });
            }
        });

        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '100%',
                width: '100%',
                videoId: '',
                playerVars: {
                    'controls': 0,
                    'showinfo': 0,
                    'modestbranding': 1,
                    'iv_load_policy': 3
                },
                events: {
                    'onReady': onYouTubePlayerReady,
                    'onStateChange': onYouTubePlayerStateChange
                }
            });

            console.log(player);
        }

        var screen = io(server + '/protube-screen');
        var pin = io(server + '/protube-pin');

        pin.on("pin", function (data) {
            $("#pinCode").html(data);
        });

        var radio = document.createElement("AUDIO");

        var radioStation = {};

        var nowPlaying = {};

        var idle = true;

        screen.on("radioStation", function (data) {
            radioStation = data;
            if (idle) startRadio();
        });

        function onYouTubePlayerReady() {
            $("#connecting").hide(0);

            screen.emit("screenReady");

            var t;

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }

            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                // add a zero in front of numbers<10
                h = checkTime(h);
                m = checkTime(m);
                $('#clock').html(h + ":" + m);
                t = setTimeout(function() {
                    startTime()
                }, 500);
            }

            startTime();

            screen.on("disconnect", function () {
                $("#connecting").show(0);
            });

            screen.on("reconnect", function () {
                $("#connecting").hide(0);
                screen.emit("screenReady");
            });

            screen.on("ytInfo", function (data) {
                nowPlaying = data;
                setNowPlaying(nowPlaying.title, nowPlaying.callingName);
                player.cueVideoById(nowPlaying.id);
                player.setPlaybackQuality('highres');
            });

            screen.on("queue", function (data) {
                $("#queue ul").html("");
                for (var i in data) {
                    var invisible = (data[i].showVideo ? '' : '<i class="fa fa-eye-slash" aria-hidden="true"></i>');
                    $("#queue ul").append(`<li><img src="https://img.youtube.com/vi/${data[i].id}/0.jpg" /><h1>${data[i].title}${invisible}</h1></li>`);
                }
            });

            screen.on("progress", function (data) {
                var progress = parseInt(data);
                if (player.getCurrentTime() != progress + 1 || progress == 0) {
                    player.seekTo(progress);
                    setProgressBar(player.getDuration(), progress);
                }
            });

            screen.on("playerState", function (data) {
                console.log("playerState", data);
                if (data.playing && !data.paused) {
                    stopIdle(data.slideshow);
                    player.playVideo();

                } else if (data.playing && data.paused) {
                    player.pauseVideo();
                    stopProgressBar(false);

                } else {
                    player.stopVideo();
                    stopProgressBar(true);
                    startIdle();
                }

                if (data.protubeOn) {
                    $("#protubeOff").hide(0);
                } else {
                    $("#protubeOff").show(0);
                }
            });

            screen.on("volume", function (data) {
                player.setVolume(data.youtube);
                radio.volume = data.radio / 100;
                soundboardVolume = data.soundboard / 100;

                // Update existing players
                for(var i = soundboardPlayers.length - 1; i >= 0; i--) {
                    soundboardPlayers[i].volume = soundboardVolume;
                }
            });

            screen.on("reload", function () {
                location.reload();
            });

            screen.on("soundboard", function(data) {
                console.log("playing sound", soundboardSounds[data].file);
                soundboardPlayer = document.createElement("AUDIO");
                soundboardPlayer.src = soundboardSounds[data].file;
                soundboardPlayer.volume = soundboardVolume;
                soundboardPlayer.play();
                soundboardPlayers.push(soundboardPlayer);

                // clean up soundboardplayers
                for(var i = soundboardPlayers.length - 1; i >= 0; i--) {
                    if(soundboardPlayers[i].paused) {
                        soundboardPlayers.splice(i, 1);
                    }
                }
            });

        }

        function onYouTubePlayerStateChange(newState) {
            if (newState.data == 1) setProgressBar();
        }

        function setProgressBar() {
            var current = player.getCurrentTime();
            var total = player.getDuration();

            var progressBar = $("#progressBar");
            var percentage = current / total * 100;

            progressBar.stop();

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
            var progressBar = $("#progressBar");
            progressBar.stop();
            if (reset) progressBar.css({width: '0%'});
        }

        function startSlideshow() {
            var slideshow = $("#slideshow");
            if (slideshow.html() == "") slideshow.html('<iframe src="/photos/slideshow" width="100%" height="100%" frameborder="0"></iframe>');
            slideshow.show(0);
        }

        function stopSlideshow() {
            var slideshow = $("#slideshow");
            slideshow.hide(0);
            slideshow.html("");
        }

        function startRadio() {
            setNowPlaying("Now playing radio: " + radioStation.name);
            radio.src = radioStation.url;
            radio.play();
        }

        function stopRadio() {
            radio.src = "";
            console.log("stopping radio");
        }

        function startIdle() {
            idle = true;

            $("#queue").hide(0);
            $("#progressBar").hide(0);
            $("#progressBarBackground").hide(0);
            $("#bottomBar").removeClass("blackBg");

            startSlideshow();
            startRadio();
        }

        function stopIdle(slideshow) {
            idle = false;

            if (!slideshow) {
                stopSlideshow();
            } else {
                startSlideshow();
            }
            stopRadio();

            $("#queue").show(0);
            $("#progressBar").show(0);
            $("#progressBarBackground").show(0);
            $("#bottomBar").addClass("blackBg");
        }

        function setNowPlaying(title, callingName) {
            $("#nowPlaying").html(title);
            $("#addedBy").html(callingName ? 'added by ' + callingName : '');
        }

        @if($showPin)
            $(document).ready(function () {
            $.ajax({
                url: "{!! config('app-proto.app-url') !!}/api/token",
                dataType: "jsonp",
                success: function (_token) {

                    token = _token.token;

                    var admin = io(server + '/protube-admin');

                    admin.on("connect", function () {
                        admin.emit("authenticate", token);
                    });

                    admin.on("pin", function (data) {
                        $("#pinCode").html(data);
                    });

                }
            });
        });
        @endif

    </script>

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-36196842-5', 'auto');
        ga('send', 'pageview');

    </script>

</head>

<body>

<div id="connecting" class="inactive">
    <p>Connecting to Herbert...</p>
</div>

<div id="protubeOff" class="inactive"></div>

<div id="topBar">
    <div id="nowPlaying">Loading...</div>
    <div id="addedBy">&nbsp;</div>

    <div id="clock"> 00:00 </div>
</div>

<div id="playerContainer">
    <div id="player"></div>
</div>

<div id="bottomBar">
    <div id="progressBar"></div>
    <div id="progressBarBackground"></div>

    <div id="pin">
        <h1>protube.nl/</h1>
        <p id="pinCode">...</p>
    </div>
    <div id="queue">
        <ul>
            <!-- Filled by JS -->
        </ul>
    </div>
</div>

<div id="slideshow"></div>

</body>
</html>