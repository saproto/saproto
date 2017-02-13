<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <title>Flickr Slideshow</title>

    <style type="text/css">
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
            left: 20px;
            top: 20px;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.8);
            color: #FFFFFF;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.2);
            font: 26px 'Roboto';
            border: 1px solid #c1ff00;
        }
    </style>

    @include('website.layouts.assets.javascripts')

    <script type="text/javascript">
        var slideInterval;

        var protoServer = '{{ URL::to('/') }}';

        $(document).ready(function () {
            startSlideshow();
        });

        function startSlideshow() {
            $.ajax({
                url: protoServer + '/api/photos',
                dataType: 'json',
                success: function (data) {
                    $('#albums').html('');
                    $(data).each(function () {
                        $('#albums').append('<option value="' + this.id + '">' + this.name + '</option>')
                    });

                    displayRandomAlbum();

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus)
                    alert('Error');
                }
            });

            $('#albums').bind('change', function () {
                displayAlbum($(this).val());
            });
        }

        function displayRandomAlbum() {
            var random = $('#albums > option:nth-child(' + Math.round(Math.random() * $('#albums > option').length) + ')').val();
            displayAlbum(random);
        }

        function displayAlbum(id) {
            $('#slideshow').addClass('loading').html('');
            $.ajax({
                url: protoServer + '/api/photos/' + id,
                dataType: 'json',
                success: function (data) {

                    $('#slideshow').removeClass('loading');

                    $('#albums > option').each(function () {
                        $(this).removeAttr('selected');
                        if ($(this).attr('value') == id) {
                            $(this).attr('selected', 'selected');
                            $('#title').html($(this).html());
                        }
                    });

                    $(data.photos).each(function () {
                        $('#slideshow').append('<div style="background-image:url(' + this.url + ');"></div>');
                    });

                    prepareSlideshow();
                    clearInterval(slideInterval);
                    slideInterval = setInterval(slide, 7500);

                }
            });
        }

        function prepareSlideshow() {
            $('#slideshow > div:first-child').addClass('active');

            var z = 1;
            $('#slideshow > div').each(function () {
                $(this).css({
                    zIndex: z
                });
                z++;
            });

        }

        function slide() {
            var next = $('#slideshow > div.active').next();
            $('#slideshow > div.active').removeClass('active');

            if (next.length > 0) {
                setTimeout(function () {
                    $(next).addClass('active');
                }, 300);
            } else {
                displayRandomAlbum();
            }
        }
    </script>

</head>
<body>

<div id="slideshow" class="loading">

</div>

<div id="title">Loading...</div>

<div id="controls">

    <select id="albums">
        <option>Loading...</option>
    </select>

</div>

</body>
</html>
