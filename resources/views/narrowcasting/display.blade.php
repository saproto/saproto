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
        body{
            position:relative;
        }
        html, #slideshow, #fullpagetext, .slide {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            margin: 0;
            padding: 0;

            overflow: hidden;

            width:100%;
            height:100%;

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

        #yt-player{
            aspect-ratio: 16 / 9;
            height: auto;
            width: 100%;
        }

    </style>

</head>

<body>
    <div id="container" style="position:relative; border-radius: inherit; background-color:#333">
        <div id="fullpagetext" class="opacity-0">

        </div>

        <div id="slideshow" class="opacity-0">

        </div>

        <div id="yt-player" class="opacity-0 w-full">
    </div>
</div>

@include('website.assets.javascripts')

<script type="text/javascript" nonce="{{ csp_nonce() }}">

    let campaigns = []
    let currentCampaign = 0
    let previousWasVideo = false
    let youtubePlayer

    function onYouTubeIframeAPIReady() {
        youtubePlayer = new YT.Player('yt-player', {
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            },
            playerVars: {
                modestbranding: 1,
                controls: 0,
                showinfo: 0
            }
        });
    }

    async function updateCampaigns() {
        await get('{{ route("api::screen::narrowcasting") }}')
            .then((data) => {
                if(campaigns.length !== 0 && campaigns.length !== data.length){
                    window.location.reload();
                }

                campaigns = data
            })
            .catch(error => console.log('Error loading campaigns from server:', error))
    }

    function onPlayerReady(event) {
        event.target.mute()
        event.target.playVideo()
    }

    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
            setTimeout(updateSlide, (youtubePlayer.getDuration()-1)*1000)
        }
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

            if (currentCampaign >= campaigns.length) {
                currentCampaign = 0
            }
            const campaign = campaigns[currentCampaign]

            //hide the last slide
            let oldSlide=document.getElementById('slide-' + (currentCampaign-1))
            if(oldSlide){
                oldSlide.classList.add('opacity-0')
            }

            if (campaign.hasOwnProperty('image')) {
                if (previousWasVideo) {
                    player.classList.add('opacity-0')
                    slides.classList.remove('opacity-0')
                }

                //show the new slide if it exists, otherwise create it
                let slide=document.getElementById('slide-' + currentCampaign)
                if(slide){
                    slide.classList.remove('opacity-0')
                }else{
                    slides.innerHTML += '<div id="slide-' + currentCampaign + '" class="slide" style="background-image: url(' + campaign.image + ');"></div>'
                }
                setTimeout(updateSlide, campaign.slide_duration * 1000);

                previousWasVideo = false;
            } else {
                youtubePlayer.loadVideoById(campaign.video, "highres");
                youtubePlayer.playVideo();

                if (!previousWasVideo) {
                    slides.classList.add('opacity-0')
                    player.classList.remove('opacity-0')
                }
                previousWasVideo = true
            }
            currentCampaign++
        }
    }


    updateCampaigns()
    setInterval(updateCampaigns, 10 * 1000)

    updateSlide()
</script>

<script type="text/javascript" src="https://www.youtube.com/iframe_api" nonce="{{ csp_nonce() }}"></script>

</body>

</html>