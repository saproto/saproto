<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>S.A. Proto | Narrowcasting</title>

    @include('website.layouts.assets.stylesheets')

    @include('website.layouts.assets.customcss')

    <style type="text/css">

        html, body, #slideshow, #fullpagetext, .slide, #protologo {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            margin: 0;
            padding: 0;

            overflow: hidden;

            background-color: #333;
        }

        #fullpagetext {
            margin: 300px 0;
            text-align: center;
            font-size: 50px;
            color: #fff;
            transition: opacity 1s;
        }

        #slideshow, #yt-player {
            transition: all 1s;
        }

        .slide {
            background-size: cover;
            background-position: center center;
            transition: all 1s;
            opacity: 1;
        }

        .slide.old {
            opacity: 0;
        }

        .slide.new {
            opacity: 0;
        }

    </style>

</head>

<body style="display: block;">

<div id="fullpagetext" style="opacity: 0;">

</div>

<div id="slideshow" style="opacity: 0;">

</div>

<div id="yt-player" style="opacity: 0;">

</div>

@include('website.layouts.assets.javascripts')

<script type="text/javascript">

    var campaigns = [];
    var currentcampaign = 0;

    var previousWasVideo = false;

    var player;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('yt-player', {
            height: window.innerHeight,
            width: window.innerWidth,
            events: {
                'onReady': onPlayerReady
            },
            playerVars: {
                modestbranding: 1,
                controls: 0,
                showinfo: 0
            }
        });
    }

    function updateCampaigns() {

        $.ajax({
            url: '{{ route("api::screen::narrowcasting") }}',
            dateType: 'json',
            success: function (data) {
                campaigns = data;
            }
        });

    }

    function onPlayerReady(event) {
        event.target.mute();
        event.target.playVideo();
    }

    function updateSlide() {

        if (campaigns.length == 0) {

            $("#fullpagetext").html("There are no messages to display. :)").css("opacity", 1);
            $("#slideshow").css("opacity", 0);
            setTimeout(updateSlide, 1000);

        } else {

            $("#fullpagetext").html("Starting slideshow... :)").css("opacity", 0);
            $("#slideshow").css("opacity", 1);

            $(".slide").addClass('old');

            var campaign;
            if (currentcampaign >= campaigns.length) {
                currentcampaign = 0;
            }
            campaign = campaigns[currentcampaign];

            if (campaign.hasOwnProperty('image')) {

                if (previousWasVideo) {
                    $("#slideshow").css("opacity", 1);
                    $("#yt-player").css("opacity", 0);
                }

                $("#slideshow").append('<div id="slide-' + campaign.id + '" class="slide new" style="background-image: url(' + campaign.image + ');"></div>');

                setTimeout(updateSlide, campaign.slide_duration * 1000);
                setTimeout(showSlide, 0);
                setTimeout(clearSlides, 2000);

                previousWasVideo = false;

            } else {

                player.loadVideoById(campaign.video, "highres");
                player.playVideo();

                if (!previousWasVideo) {
                    $("#slideshow").css("opacity", 0);
                    $("#yt-player").css("opacity", 1);
                }

                setTimeout(updateSlide, (campaign.slide_duration - 1) * 1000);
                setTimeout(clearSlides, 2000);

                previousWasVideo = true;

            }

            currentcampaign++;

        }

    }

    function showSlide() {
        $(".slide.new").removeClass('new');
    }

    function clearSlides() {
        $(".slide.old").remove();
    }

    $(document).ready(function () {

        updateCampaigns();
        setInterval(updateCampaigns, 10 * 1000);

        updateSlide();

    });

</script>

<script type="text/javascript" src="https://www.youtube.com/iframe_api"></script>

</body>

</html>