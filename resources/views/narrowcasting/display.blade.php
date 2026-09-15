@push('stylesheet')
    <style>
        #container {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9 !important;
            background-color: #333;
            margin: 0;
            padding: 0;
            padding-bottom: 56.25%;
            overflow: hidden;
        }

        #slideshow,
        #fullpagetext,
        #video-player,
        .video,
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            height: 100%;

            background-color: #333;
        }

        #fullpagetext {
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 1s;
        }

        #text-container {
            text-align: center;
            font-size: 50px;
            color: #fff;
        }

        #slideshow,
        #video-player {
            transition: all 1s;
        }

        .slide {
            background-size: cover;
            background-position: center center;
            transition: all 1s;
            opacity: 1;
        }
    </style>
@endpush

<div id="container">
    <div id="fullpagetext" class="opacity-0">
        <div id="text-container"></div>
    </div>

    <div id="slideshow" class="opacity-0"></div>
    <div id="video-player" class="w-full opacity-0"></div>
</div>

@push('javascript')
    <script type="text/javascript" @cspNonce>
        let campaigns = []
        let currentCampaign = 0
        const hideClass = 'opacity-0'

        async function updateCampaigns() {
            await get('{{ route('api::screen::narrowcasting') }}')
                .then((data) => {
                    if (
                        campaigns.length !== 0 &&
                        campaigns.length !== data.length
                    ) {
                        window.location.reload()
                    }

                    campaigns = data
                    updateSlide()
                })
                .catch((error) =>
                    console.log('Error loading campaigns from server:', error)
                )
        }

        function updateSlide() {
            const text = document.getElementById('fullpagetext')
            const textContainer = document.getElementById('text-container')
            const slides = document.getElementById('slideshow')
            const player = document.getElementById('video-player')

            if (campaigns.length === 0) {
                textContainer.innerHTML = 'There are no messages to display. :)'
                text.classList.remove(hideClass)
                slides.classList.add(hideClass)
                player.classList.add(hideClass)
                setTimeout(updateSlide, 1000)
            } else {
                textContainer.innerHTML = 'Loading slideshow... :)'
                text.classList.add(hideClass)
                player.classList.add(hideClass)
                slides.classList.add(hideClass)

                if (currentCampaign >= campaigns.length) {
                    currentCampaign = 0
                }
                const campaign = campaigns[currentCampaign]
                if (campaign.is_video === false) {
                    slides.classList.remove(hideClass)

                    //show the new slide if it exists, otherwise create it
                    let slide = document.getElementById(
                        'slide-' + currentCampaign
                    )
                    if (slide) {
                        slide.classList.remove(hideClass)
                    } else {
                        slides.innerHTML +=
                            '<div id="slide-' +
                            currentCampaign +
                            '" class="slide" style="background-image: url(' +
                            campaign.image +
                            ');"></div>'

                        slide = document.getElementById(
                            'slide-' + currentCampaign
                        )
                    }
                    setTimeout(() => {
                        slide.classList.add(hideClass)
                        updateSlide()
                    }, campaign.slide_duration * 1000)
                } else {
                    player.classList.remove(hideClass)
                    let video = document.getElementById(
                        'video-' + currentCampaign
                    )
                    if (video) {
                        video.classList.remove(hideClass)
                    } else {
                        player.innerHTML +=
                            '<video id="video-' +
                            currentCampaign +
                            '" autoplay muted class="video">' +
                            '<source src="' +
                            campaign.image +
                            '" type="video/mp4"></video>'

                        video = document.getElementById(
                            'video-' + currentCampaign
                        )
                    }
                    video.currentTime = 0
                    video.play()
                    video.addEventListener('ended', () => {
                        video.classList.add(hideClass)
                        updateSlide()
                    }, { once: true })
                }
                currentCampaign++
            }
        }

        window.addEventListener('load', () => {
            updateCampaigns()
            const everyTwoHours = 60 * 60 * 2 * 1000
            setInterval(updateCampaigns, everyTwoHours)
        })
    </script>
@endpush
