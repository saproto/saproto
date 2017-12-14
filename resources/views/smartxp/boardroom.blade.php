<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>
    
    <meta http-equiv="refresh" content="3600">

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>Board Room Status Screen</title>

    @include('website.layouts.assets.stylesheets')

    <style type="text/css">

        * {
            box-sizing: border-box;
        }

        html, body {
            font-family: Lato, sans-serif;

            padding: 15px 10px;
            margin: 0;

            background-color: #555;
        }

        .container-fluid, .row, .col-md-4 {
            height: 100%;
        }

        .box-partial {
            padding: 20px 0;
        }

        .box-partial:nth-child(1) {
            padding-top: 0;
        }

        .box-partial:nth-last-child(1) {
            padding-bottom: 0;
        }

        .box {
            position: relative;

            background-color: rgba(0, 0, 0, 0.5);
            border-bottom: 5px solid #c1ff00;
            box-shadow: 0 0 20px -7px #000;

            overflow: hidden;
        }

        .box-header {
            font-size: 30px;
            font-weight: bold;

            color: #fff;

            text-align: left;

            padding: 15px 0;
            margin: 0 40px;
            border-bottom: 2px solid #fff;
        }

        .box-header.small {
            font-size: 20px;

            margin: 0px 10px;
        }

        .box-footer {
            text-align: left;
            font-weight: bold;
            color: #fff;
            padding: 15px;
            font-size: 20px;
        }

        .notice {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            color: #fff;
        }

        #time {
            position: absolute;

            top: 0;
            left: 15px;

            height: 70px;
            line-height: 50px;

            padding: 5px 0;

            font-weight: bold;

            border-bottom: 0;

            color: #fff;
            font-size: 35px;
            width: 185px;

            overflow: visible;
        }

        #ticker {
            position: absolute;

            bottom: 0;
            left: 0;

            height: 5px;
            width: 100%;

            background-color: #c1ff00;
        }

        .activity {
            width: 100%;

            color: #fff;

            text-align: left;

            padding: 20px 40px;

            font-size: 20px;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .activity:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .activity.past {
            opacity: 0.5;
        }

        .activity.current {
            color: #c1ff00;
        }

        .reservation__time {
            display: block;
            float: left;
            width: 150px;
        }

        #boardroom__status {
            float: right;
        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <div class="col-md-8">

            <div class="box" style="height: 100%;">

                <div class="box-header">

                    Board Room of S.A. Proto (A124) <span id="boardroom__status">Checking...</span>

                </div>

                <div id="timetable">

                    <div class="notice">Loading...</div>

                </div>

            </div>

            <div class="box-footer">
                Reservations via the board of S.A. Proto (A230)
                <span style="float: right">board@proto.utwente.nl &nbsp;&nbsp;&nbsp; 053 489 4423</span>
            </div>

        </div>

        <div class="col-md-4">

            <div class="box-partial" style="height: 33.33%; text-align: center;">

                <div id="time" class="box">
                    <div id="clock">
                        NOW!
                    </div>
                    <div id="ticker"></div>
                </div>

                <br>

                <img src="{{ asset('images/logo/inverse.png') }}" style="max-width: 100%; max-height: 100%;"/>

            </div>

        </div>

    </div>

</div>

@section('javascript')
    @include('website.layouts.assets.javascripts')
@show

<script type="text/javascript">

    function updateClock() {
        var now = moment();
        $("#clock").html(now.format('HH:mm:ss'));
        $("#ticker").css("width", ((now.format('s.SSS') / 60) * 100) + "%");
    }

    setInterval(updateClock, 10);

    function updateTimetable() {
        $.ajax({
            url: '{{ route('api::timetable::boardroom') }}',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $("#timetable").html('');
                    var current_day = -1;
                    var occupied = false;
                    for (i in data) {
                        var start = moment.unix(data[i].start);
                        var end = moment.unix(data[i].end);

                        var this_day = start.format('DDD');
                        var display_day = false;
                        if (this_day !== current_day) {
                            current_day = this_day;
                            display_day = true;
                        }

                        var day = start.format("dddd");
                        var date = start.format("MMMM Do");
                        var time = start.format("HH:mm") + ' - ' + end.format("HH:mm");

                        if (display_day) {
                            var day_display_text = "<span class='reservation__day'><strong>" + day + "</strong> (" + date + ")</span><br>";
                        } else {
                            var day_display_text = "";
                        }

                        if (data[i].current) {
                            occupied = true;
                        }

                        $("#timetable").append('<div class="activity ' + (data[i].current ? "current" : (data[i].over ? "past" : "")) + '">' + day_display_text + '<span class="reservation__time">' + time + '</span> <strong>' + data[i].title + '</strong></div>');
                        $("#boardroom__status").html(occupied ? 'Occupied' : 'Available');
                    }
                } else {
                    $("#timetable").html('<div class="notice">No lectures today!</div>');
                }
                setTimeout(updateTimetable, 60000);
            },
            error: function () {
                $("#timetable").html('<div class="notice">Something went wrong during retrieval...</div>');
                setTimeout(updateTimetable, 5000);
            }
        })
    }

    updateTimetable();


</script>

</body>

</html>
