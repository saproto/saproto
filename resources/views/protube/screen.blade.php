<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

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

        #connecting {
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

        #connecting p {
            position: absolute;
            top: 48%;
            left: 0;
            right: 0;

            text-align: center;

            margin: 0;
            padding: 0;

            color: #c1ff00;
        }

        #progressBar {
            position: absolute;
            bottom: 135px;
            left: 0;
            width: 0;
            height: 5px;

            background-color: #c1ff00;

            z-index: 500;
        }

        #progressBarBackground {
            position: absolute;
            bottom: 135px;
            left: 0;
            width: 100%;
            height: 5px;

            background-color: #222222;

            z-index: 400;
        }

        #playerContainer {
            position: absolute;
            top: 0px;
            bottom: 140px;
            left: 0;
            right: 0;
        }


        #nowPlaying {
            position: absolute;
            z-index: 9999;
            display: block;
            right: 20px;
            top: 20px;
            padding: 15px 20px;
            background: rgba(0,0,0,0.8);
            color: #FFFFFF;
            text-shadow: 0 1px 1px rgba(255,255,255,0.2);
            font-size: 26px;
            border: 1px solid #c1ff00;
        }

        #player {

        }

        #bottomBar {
            position: absolute;

            bottom: 0;
            left: 0;

            width: 100%;
            height: 135px;

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

            width: 200px;
            height: 135px;
            text-align: center;

            margin: 0;
            padding: 0;

            background-color: rgba(0,0,0,0.5);
        }

        #pin h1 {
            color: #c1ff00;
            font-size: 16px;

            margin: 0;
            padding: 0;

            margin-top: 20px;
        }

        #pin p {
            color: #fff;
            font-size: 72px;

            margin: 0;
            padding: 0;
            padding-top: 5px;
        }

        #queue {
            position: absolute;
            bottom: 0;
            left: 200px;
            right: -3000px;

            height: 135px;

            overflow-x: hidden;
        }

        #queue ul {
            position: relative;
            padding: 0;
            margin: 0;
        }

        #queue ul li {
            position: relative;
            width: 180px;
            height: 135px;
            display: inline-block;
            padding: 0;
            margin: 0;
        }

        #queue ul li h1 {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 160px;
            height: 115px;
            overflow: hidden;
            font-size: 16px;
            font-weight: normal;
            color: #fff;
            text-shadow: #000 1px 1px;
            margin: 0;
            padding: 0;
        }

        #queue img {
            position: absolute;
            top: 0;
            left: 0;
            height: 135px;
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
        var server = "{!! env('HERBERT_SERVER') !!}";

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

        pin.on("pin", function(data) {
            $("#pinCode").html(data);
        });

        var radio = document.createElement("AUDIO");

        var radioStation = {};

        var nowPlaying = {};

        screen.on("radioStation", function(data) {
            radioStation = data;
        });

        function onYouTubePlayerReady() {
            $("#connecting").hide(0);

            screen.emit("screenReady");

            screen.on("disconnect", function() {
                $("#connecting").show(0);
            });

            screen.on("reconnect", function() {
                $("#connecting").hide(0);
                screen.emit("screenReady");
            });

            screen.on("ytInfo", function(data) {
                nowPlaying = data;
                setNowPlaying(nowPlaying.title);
                player.cueVideoById(nowPlaying.id);
                player.setPlaybackQuality('highres');
            });

            screen.on("queue", function(data) {
                $("#queue ul").html("");
                for(var i in data) {
                    var invisible = (data[i].showVideo ? '' : '<i class="fa fa-eye-slash" aria-hidden="true"></i>');
                    $("#queue ul").append(`<li><img src="http://img.youtube.com/vi/${data[i].id}/0.jpg" /><h1>${data[i].title}${invisible}</h1></li>`);
                }
            });

            screen.on("progress", function(data) {
                var progress = parseInt(data);
                if(player.getCurrentTime() != progress+1 || progress == 0) {
                    player.seekTo(progress);
                    setProgressBar(player.getDuration(), progress);
                }
            });

            screen.on("playerState", function(data) {
                console.log("playerState", data);
                if(data.playing && !data.paused) {
                    stopIdle(data.slideshow);
                    player.playVideo();

                } else if(data.playing && data.paused) {
                    player.pauseVideo();
                    stopProgressBar(false);

                } else {
                    player.stopVideo();
                    stopProgressBar(true);
                    startIdle();
                }
            });

            screen.on("volume", function(data) {
                player.setVolume(data.youtube);
                radio.volume = data.radio / 100;
            });

            screen.on("reload", function() {
                location.reload();
            });
        }

        function onYouTubePlayerStateChange(newState) {
            if(newState.data == 1) setProgressBar();
        }

        function setProgressBar() {
            var current = player.getCurrentTime();
            var total = player.getDuration();

            var progressBar = $("#progressBar");
            var percentage = current/total * 100;

            progressBar.stop();

            progressBar.css({
                width: percentage + '%'
            });

            progressBar.animate({
                width: '100%'
            }, (total - current) * 1000, 'linear', function(){
                $(this).css({
                    width: '0%'
                });
            });
        }

        function stopProgressBar(reset) {
            var progressBar = $("#progressBar");
            progressBar.stop();
            if(reset) progressBar.css({ width: '0%' });
        }

        function startSlideshow() {
            var slideshow = $("#slideshow");
            if(slideshow.html() == "") slideshow.html('<iframe src="/photos/slideshow" width="100%" height="100%" frameborder="0"></iframe>');
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
            $("#queue").hide(0);
            $("#progressBar").hide(0);
            $("#progressBarBackground").hide(0);
            $("#bottomBar").removeClass("blackBg");

            startSlideshow();
            startRadio();
        }

        function stopIdle(slideshow) {
            if(!slideshow) {
                stopSlideshow();
            }else{
                startSlideshow();
            }
            stopRadio();

            $("#queue").show(0);
            $("#progressBar").show(0);
            $("#progressBarBackground").show(0);
            $("#bottomBar").addClass("blackBg");
        }

        function setNowPlaying(title) {
            $("#nowPlaying").html(title);
        }
    </script>
</head>

<body>

<div id="connecting">
    <p>Connecting to Herbert...</p>
</div>

<div id="playerContainer">
    <div id="nowPlaying">Loading...</div>
    <div id="player"></div>
</div>

<div id="progressBar"></div>
<div id="progressBarBackground"></div>

<div id="bottomBar">
    <div id="pin">
        <h1>www.protube.nl</h1>
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