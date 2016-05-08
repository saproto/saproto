<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>S.A. Proto | @yield('page-title','Default Page Title')</title>

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
        }

        #fullpagetext {
            margin: 300px 0;
            text-align: center;
            font-size: 50px;
            color: #fff;
            transition: opacity 2s;
        }

        #slideshow {
            transition: opacity 2s;
        }

        .slide {
            background-size: cover;
            background-position: center center;
            transition: transform 2s;
            transform: translate(0,0);
        }
        .slide.old {
            transform: translate(0, 100%);
        }
        .slide.new {
            transform: translate(0, -100%);
        }

        #protologo img {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 300px;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 8px;
            padding: 20px;
            opacity: 0.8;
        }

    </style>

</head>

<body style="display: block;">

<div id="fullpagetext" style="opacity: 0;">

</div>

<div id="slideshow" style="opacity: 0;">

</div>

<div id="protologo">
    <img src="{{ asset('images/logo/inverse.png') }}">
</div>

@include('website.layouts.assets.javascripts')

<script type="text/javascript">

    var campaigns = [];
    var currentcampaign = 0;

    var imagepath = '{!! route("file::get", ["id" => "!!id!!"]) !!}';

    function updateCampaigns() {

        $.ajax({
            url: '{{ route("narrowcasting::api::list") }}',
            dateType: 'json',
            success: function (data) {
                campaigns = data;
            }
        });

    }

    function updateSlide() {

        if (campaigns.length == 0) {
            $("#fullpagetext").html("There are no messages to display. :)").css("opacity", 1);
            $("#slideshow").css("opacity", 0);
            setTimeout(updateSlide, 1000)
        } else {
            $("#fullpagetext").html("Starting slideshow... :)").css("opacity", 0);
            $("#slideshow").css("opacity", 1);

            $(".slide").addClass('old');

            var campaign;
            if (currentcampaign >= campaigns.length) {
                currentcampaign = 0;
            }
            campaign = campaigns[currentcampaign];

            var campaignimage = imagepath.replace('!!id!!', campaign.image_id);
            console.log(campaignimage);
            $("#slideshow").append('<div id="slide-' + campaign.id + '" class="slide new" style="background-image: url(' + campaignimage + ');"></div>');

            currentcampaign++;

            setTimeout(updateSlide, campaign.slide_duration * 1000);
            setTimeout(showSlide, 500);
            setTimeout(clearSlides, 2000);
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

</body>

</html>