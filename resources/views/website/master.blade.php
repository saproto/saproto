<!DOCTYPE html>
<html lang="en" style="position: relative; min-height: 100%;">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <meta name="theme-color" content="#C1FF00">

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>
    <link rel="search" type="application/opensearchdescription+xml" title="S.A. Proto"
          href="{{ route('search::opensearch') }}"/>

    <title>@if(config('app.env') != 'production') [{{ strtoupper(config('app.env')) }}] @endif S.A. Proto
        | @yield('page-title','Default Page Title')</title>

    @section('head')
    @show

    @include('website.layouts.assets.stylesheets')

    @section('stylesheet')
        @include('website.layouts.assets.customcss')
    @show

    @section('opengraph')
        <meta property="og:url" content="{{ Request::url() }}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="@yield('page-title','Website')"/>
        <meta property="og:description"
              content="@yield('og-description','S.A. Proto is the study association for Creative Technology at the University of Twente.')"/>
        <meta property="og:image"
              content="@yield('og-image',asset('images/logo/og-image.png'))"/>
    @show

</head>

<body class="template-{{ $viewName }}"
      style="background-color: #f3f3f3; margin-bottom: 216px; @section('body-style')@show">

@yield('body')

@if(!App::isDownForMaintenance())

@section('javascript')
    @include('website.layouts.assets.javascripts')
    <script>

        var Trail = function(options) {
            this.size        = options.size || 50;
            this.trailLength = options.trailLength || 20;
            this.interval    = options.interval || 15;
            this.hueSpeed    = options.hueSpeed || 6;

            this.boxes = [];
            this.hue   = 0;
            this.mouse = {
                x : window.innerWidth/2,
                y : window.innerHeight/2
            };

            this.init = function() {
                for (var i = 0; i < this.trailLength; i++) {
                    this.boxes[i]              = document.createElement('div');
                    this.boxes[i].className    = 'box';
                    this.boxes[i].style.width  = this.size + 'px';
                    this.boxes[i].style.height = this.size + 'px';
                    document.body.appendChild(this.boxes[i]);
                }

                var self = this;

                // document.onmousemove = function() {
                //   event = event || window.event;
                //   self.mouse.x = event.clientX;
                //   self.mouse.y = event.clientY;
                //   console.log(event);
                // };

                //Periodically update mouse tracing and boxes
                setInterval(function(){
                    self.updateHue();
                    self.updateBoxes();
                }, this.interval);
            }

            //Update hue and constrain to 360
            this.updateHue = function() {
                this.hue = (this.hue + this.hueSpeed) % 360;
            }

            //Update box positions and stylings
            this.updateBoxes = function() {
                for (var i = 0; i < this.boxes.length; i++) {
                    if (i+1 === this.boxes.length) {
                        this.boxes[i].style.top             = this.mouse.y - this.size/2 + 'px';
                        this.boxes[i].style.left            = this.mouse.x - this.size/2 + 'px';
                        this.boxes[i].style.backgroundColor = 'hsl(' + this.hue + ', 90%, 50%)';
                    } else {
                        this.boxes[i].style.top             = this.boxes[i+1].style.top;
                        this.boxes[i].style.left            = this.boxes[i+1].style.left;
                        this.boxes[i].style.backgroundColor = this.boxes[i+1].style.backgroundColor;
                    }
                }
            }
        }

        var options = {
            trailLength: 30,
            size: 50,
            interval: 10,
            hueSpeed: 2
        };
        var trail = new Trail(options);
        trail.init();

        //Hotfix
        document.onmousemove = function() {
            trail.mouse.x = event.clientX;
            trail.mouse.y = event.clientY;
        };

    </script>
@show

@include('website.layouts.macros.flashmessages')

@include('website.layouts.macros.errormessages')

@endif

@include('slack.modal')

</body>

</html>
