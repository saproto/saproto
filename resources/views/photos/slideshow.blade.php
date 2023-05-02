<html lang="en">
<head>
    <title>Photo Slideshow</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900,900italic,300italic,300,100italic,100');

        body, html {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            background: black;
        }

        #slideshow {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            overflow: hidden;
        }

        #slideshow.loading {
            background: url(data:image/gif;base64,R0lGODlhKwALAPEAAAAAAH2Eqj1AUn2EqiH+GkNyZWF0ZWQgd2l0aCBhamF4bG9hZC5pbmZvACH5BAAKAAAAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAKwALAAACMoSOCMuW2diD88UKG95W88uF4DaGWFmhZid93pq+pwxnLUnXh8ou+sSz+T64oCAyTBUAACH5BAAKAAEALAAAAAArAAsAAAI9xI4IyyAPYWOxmoTHrHzzmGHe94xkmJifyqFKQ0pwLLgHa82xrekkDrIBZRQab1jyfY7KTtPimixiUsevAAAh+QQACgACACwAAAAAKwALAAACPYSOCMswD2FjqZpqW9xv4g8KE7d54XmMpNSgqLoOpgvC60xjNonnyc7p+VKamKw1zDCMR8rp8pksYlKorgAAIfkEAAoAAwAsAAAAACsACwAAAkCEjgjLltnYmJS6Bxt+sfq5ZUyoNJ9HHlEqdCfFrqn7DrE2m7Wdj/2y45FkQ13t5itKdshFExC8YCLOEBX6AhQAADsAAAAAAAAAAAA=) no-repeat center center;
        }

        #slideshow > div {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            opacity: 0;
            background-position: bottom right;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: black;

            -moz-transition: -moz-transform 1s, opacity 1s, background-position 5s 2s;
            -moz-transform: rotateZ(10deg) scale(0.75);
            -moz-backface-visibility: hidden;

            -webkit-transition: -webkit-transform 1s, opacity 1s, background-position 5s 2s;
            -webkit-transform: rotateZ(10deg) scale(0.75);
            -webkit-backface-visibility: hidden;

            -o-transition: -webkit-transform 1s, opacity 1s, background-position 5s 2s;
            -o-transform: rotateZ(10deg) scale(0.75);
            -o-backface-visibility: hidden;

            transition: -webkit-transform 1s, opacity 1s, background-position 5s 2s;
            transform: rotateZ(10deg) scale(0.75);
            backface-visibility: hidden;
        }

        body.contain #slideshow > div {
            background-position: center center !important;
            background-size: contain;
        }

        #slideshow > div:nth-child(2n-1) {
            -moz-transform: rotateZ(-10deg) scale(0.75);
            -webkit-transform: rotateZ(-10deg) scale(0.75);
            -o-transform: rotateZ(-10deg) scale(0.75);
            transform: rotateZ(-10deg) scale(0.75);
            background-position: top left;

        }

        #slideshow > div.active:nth-child(2n-1) {
            background-position: bottom right;
        }

        #slideshow > div.active {
            opacity: 1;
            -moz-transform: rotateZ(0deg) scale(1);
            -webkit-transform: rotateZ(0deg) scale(1);
            -o-transform: rotateZ(0deg) scale(1);
            transform: rotateZ(0deg) scale(1);
            background-position: top left;
        }

        #controls {
            position: absolute;
            z-index: 9999999;
            top: 10px;
            left: 10px;
            opacity: 0;
            -webkit-transition: opacity 0.2s;
        }

        #title {
            position: absolute;
            z-index: 999999;
            display: block;
            left: 30px;
            bottom: 130px;
            color: #FFFFFF;
            text-shadow: 0 0 10px rgba(0, 0, 0, 1);
            font: 30px 'Roboto';
        }
    </style>

    @include('website.assets.javascripts')

</head>
<body>

<div id="slideshow" class="loading"></div>

<div id="title">Loading...</div>

<div id="controls">
    <select id="albums">
        <option>Loading...</option>
    </select>
</div>

<script type="text/javascript" nonce="{{ csp_nonce() }}">
    let slideInterval

    const albumEl = document.getElementById('albums')
    const albumOptionList = Array.from(document.querySelectorAll('#albums > option'))
    const MONTH_NAMES = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"]

    startSlideshow()

    function startSlideshow() {
        get('{{ route("api::photos::albums") }}')
            .then(data => {
                albumEl.innerHTML = ''
                for (const album of data) {
                    const albumDate = new Date(album['date_taken'] * 1000)
                    album.innerHTML += `<option value="${album.id}">${album.name} (${MONTH_NAMES[albumDate.getMonth()]} ${albumDate.getFullYear()})</option>`
                }
                displayRandomAlbum()
            })
            .catch(err => {
                console.error(err)
            })
        albumEl.addEventListener('change', _ => {
            displayAlbum(albumEl.value)
        })
    }

    function displayRandomAlbum() {
        if (albumOptionList.length > 1) {
            let i = Math.round(Math.random() * albumOptionList.length)
            let random = document.querySelector(`#albums > option:nth-child(${i})`).value
            displayAlbum(random)
        } else {
            console.warn('There are no images to display')
        }
    }

    function displayAlbum(id) {
        const slideshow = document.getElementById('slideshow')
        slideshow.classList.add('loading')
        slideshow.innerHTML = ''

        get('{{ route("api::photos::albumList") }}/' + id)
            .then(data => {
                slideshow.classList.remove('loading')
                albumOptionList.forEach(el => {
                    el.removeAttribute('selected')
                    if (el.value === id) {
                        el.selected = true
                        document.getElementById('title').innerHTML = el.innerHTML
                    }
                })

                data['photos'].forEach(el => {
                    slideshow.innerHTML += '<div style="background-image:url(' + el.url + ');"></div>'
                })

                prepareSlideshow()
                clearInterval(slideInterval)
                slideInterval = setInterval(slide, 7500)
            })
    }

    function prepareSlideshow() {
        document.querySelector('#slideshow > div:first-child').classList.add('active')
        const slides = Array.from(document.querySelectorAll('#slideshow > div'))
        slides.forEach(el => {
            el.style.zIndex = this.z++
        }, {z: 1})
    }

    function slide() {
        const active = document.querySelector('#slideshow > div.active')
        const next = active.nextSibling
        active.classList.remove('active')
        if (next.length > 0) setTimeout(function () {
            next.classList.add('active')
        }, 300)
        else displayRandomAlbum()
    }
</script>

</body>
</html>
