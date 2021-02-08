@extends('website.layouts.redesign.generic-nonavandfooter')

@section('page-title')
    Is Alfred There?
@endsection

@push('head')
    <meta http-equiv="refresh" content="86400">
@endpush

@section('container')

    <div class="row" style="color: #fff;">

        <div class="col-md-12 text-center">

            <h1 class="mt-5 mb-5" style="font-size: 60px;">Is Alfred There?</h1>

            <h1 class="mt-5 mb-5" data-countdown-text-counting="Nope. Alfred will be back in {}."
                data-countdown-text-finished="Alfred should be there. 👀" id="alfred-text">
                We're currently looking for Alfred, please stand by...
            </h1>
            <h4 id="alfred-actualtime"></h4>

            <h1 class="mt-5 mb-5" id="alfred-emoji" style="font-size: 120px;">🤔</h1>

            <a href="//{{ config('app-proto.primary-domain') }}{{ route('homepage', [], false) }}">
                <img src="{{ asset('images/logo/inverse.png') }}" height="120px">
            </a>

        </div>

    </div>

@endsection

@push('stylesheet')

    <style rel="stylesheet" type="text/css">
        body {
            background-color: darkorange;
        }
        main {
            border: none !important;
        }
        .main-footer {
            display: none !important;
        }
    </style>

@endpush

@push('javascript')
    <script type="text/javascript">
        let alfredCountdownStarted = false;

        $(document).ready(function () {
            lookForAlfred();
            setInterval(lookForAlfred, 60000);
        });

        function lookForAlfred() {
            $.ajax({
                url: '//{{ config('app-proto.primary-domain') }}{{ route('api::isalfredthere', [], false) }}',
                dataType: 'json',
                success: function (data) {
                    if (data.status == "there") {
                        $("#alfred-text").removeClass("proto-countdown").html("Alfred is there!");
                        $("#alfred-actualtime").html("").hide();
                        $("#alfred-emoji").html("🎉😁");
                        $("body").css("background-color", 'darkgreen');
                    } else if (data.status == "unknown") {
                        $("#alfred-text").removeClass("proto-countdown").html("We couldn't find Alfred...");
                        $("#alfred-actualtime").html("").hide();
                        $("#alfred-emoji").html("👀");
                        $("body").css("background-color", 'darkorange');
                    } else if (data.status == "away") {
                        $("#alfred-text").addClass("proto-countdown").attr("data-countdown-start", data.backunix);
                        $("#alfred-actualtime").html("That would be " + data.back + ".").show();
                        $("#alfred-emoji").html("😞🕓");
                        if (!alfredCountdownStarted) {
                            initializeCountdowns();
                            alfredCountdownStarted = true;
                        }
                        $("body").css("background-color", 'darkred');
                    }
                },
                error: function () {
                    $("#alfred-text").html("We couldn't find Alfred...");
                    $("#alfred-emoji").html("👀");
                    $("body").css("background-color", 'darkorange');
                }
            })

        }
    </script>

@endpush