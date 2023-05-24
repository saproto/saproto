<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>S.A. Proto | Narrowcasting</title>

    @include('website.assets.stylesheets')

    <style>

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

<body class="d-block">

<div id="fullpagetext" class="opacity-0">

</div>

<div id="slideshow" class="opacity-0">

</div>

<div id="yt-player" class="opacity-0">

</div>

@include('website.assets.javascripts')

<script type="text/javascript" nonce="{{ csp_nonce() }}">

    let campaigns = []
    let currentCampaign = 0
    let previousWasVideo = false
    let youtubePlayer

    function onYouTubeIframeAPIReady() {
        youtubePlayer = new YT.Player('yt-player', {
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

    async function updateCampaigns() {
        await get('{{ route("api::screen::narrowcasting") }}').then(data => campaigns = data).catch(error => console.log('Error loading campaigns from server:', error))
    }

    function onPlayerReady(event) {
        event.target.mute()
        event.target.playVideo()
    }

    function updateSlide() {
        const text = document.getElementById('fullpagetext')
        const slides = document.getElementById('slideshow')
        const player = document.getElementById('yt-player')

        if (campaigns.length === 0) {
            text.innerHTML = "There are no messages to display. :)"
            text.classList.remove('opacity-0')
            slides.classList.add('opacity-0')
            setTimeout(updateSlide, 1000)
        } else {
            text.innerHTML = 'Starting slideshow... :)'
            text.classList.add('opacity-0')
            slides.classList.remove('opacity-0')
            slides.classList.add('old')

            if (currentCampaign >= campaigns.length) {
                currentCampaign = 0
            }
            const campaign = campaigns[currentCampaign]

            if (campaign.hasOwnProperty('image')) {
                if (previousWasVideo) {
                    player.classList.remove('opacity-0')
                    slides.classList.add('opacity-0')
                }

                slides.innerHTML += '<div id="slide-' + campaign.id + '" class="slide new" style="background-image: url(' + campaign.image + ');"></div>'

                setTimeout(updateSlide, campaign.slide_duration * 1000);
                setTimeout(showSlide, 0);
                setTimeout(clearSlides, 2000);

                previousWasVideo = false;
            } else {
                youtubePlayer.loadVideoById(campaign.video, "highres");
                youtubePlayer.playVideo();

                if (!previousWasVideo) {
                    slides.classList.add('opacity-0')
                    player.classList.remove('opacity-0')
                }

                setTimeout(updateSlide, (campaign.slide_duration - 1) * 1000)
                setTimeout(clearSlides, 2000)

                previousWasVideo = true
            }
            currentCampaign++
        }
    }

    function showSlide() {
        const newSlides = Array.from(document.querySelectorAll('.slide.new'))
        newSlides.forEach(el => el.classList.remove('new'))
    }

    function clearSlides() {
        const oldSlides = Array.from(document.querySelectorAll('.slide.old'))
        oldSlides.forEach(el => el.remove())
    }


    updateCampaigns()
    setInterval(updateCampaigns, 10 * 1000)

    updateSlide()
</script>

<script type="text/javascript" src="https://www.youtube.com/iframe_api" nonce="{{ csp_nonce() }}"></script>

</body>

</html>