<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>SmartXP Screen v3</title>

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

            text-align: center;

            padding: 15px 0;
            margin: 0 40px;
            border-bottom: 2px solid #fff;
        }

        .box-header.small {
            font-size: 20px;

            margin: 0px 10px;
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
            width: 250px;

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

        .busentry {
            padding: 5px 10px 5px 10px;
            color: #fff;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .busentry:nth-child(1) {
            padding-top: 10px;
        }

        .busentry:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        #protube {
            position: relative;

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            border-bottom: none;
        }

        #protube.inactive {
            background-image: url('{{ getenv('FISHCAM_URL') }}') !important;
        }

        #protube-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-shadow: 0 0 5px #000;
            border: none;
        }

        #protube-ticker {
            position: absolute;

            bottom: 0;
            left: 0;

            height: 5px;
            width: 100%;

            background-color: #c1ff00;
        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <div class="col-md-4">

            <div class="box-partial" style="height: 90%;">

                <div class="box" style="height: 100%;">

                    <div class="box-header">

                        📅 CreaTe Timetable

                    </div>

                    <div id="timetable">

                        <div class="notice">Loading timetable...</div>

                    </div>

                </div>

            </div>

            <div class="box-partial" style="height: 10%;">

                <div class="box" style="height: 100%;">

                    <div id="protopener" class="notice">Loading Protopener...</div>

                </div>

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

            <div class="box-partial" style="height: 33.33%;">

                <div id="protube" class="box inactive" style="height: 100%;">

                    <div id="protube-title" class="box-header">
                        Connecting to ProTube...
                    </div>

                    <div id="protube-ticker"></div>

                </div>

            </div>

            <div class="box-partial" style="height: 33.33%;">

                <div class="box" style="height: 100%;">

                    <div class="col-md-6">

                        <div class="box-header small">
                            🚍 Hallenweg
                        </div>

                        <div id="businfo-hallen" class="businfo">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="box-header small">
                            🚍 Westerbegraafplaats
                        </div>

                        <div id="businfo-wester" class="businfo">

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="box-partial" style="height: 66.66%;">

                <div class="box" style="height: 100%;">

                    <div class="box-header">

                        📅 Upcoming Activities

                    </div>

                    <div id="activities">

                        <div class="notice">Loading activities...</div>

                    </div>

                </div>

            </div>

            <div class="box-partial" style="height: 33.33%;">

                <div id="boardroom" class="box" style="height: 100%;">

                    <div id="boardroom-title" class="box-header small">
                        📅 Boardroom Timetable
                    </div>

                    <div id="boardroom-timetable"></div>

                </div>

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
        $("#clock").html('⏰ ' + now.format('HH:mm:ss'));
        $("#ticker").css("width", ((now.format('s.SSS') / 60) * 100) + "%");
    }

    setInterval(updateClock, 10);

    function updateTimetable() {
        $.ajax({
            url: '{{ route('api::timetable') }}',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $("#timetable").html('');
                    var count = 0;
                    for (i in data) {
                        if (!data[i].over) {
                            var start = moment.unix(data[i].start);
                            var end = moment.unix(data[i].end);
                            var time = start.format("HH:mm") + ' - ' + end.format("HH:mm");
                            $("#timetable").append('<div class="activity ' + (data[i].current ? "current" : (data[i].over ? "past" : "")) + '">' + time + ' (' + data[i].type + ') @ ' + data[i].place + '<br><strong>' + data[i].title + '</strong></div>');
                            count++;
                        }
                    }
                    if (count == 0) {
                        $("#timetable").html('<div class="notice">No more lectures today! 😃</div>');
                    }
                } else {
                    $("#timetable").html('<div class="notice">No lectures today! 😃</div>');
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

    function updateActivities() {
        $.ajax({
            url: '{{ route('api::events::upcoming', ['limit' => 10]) }}',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $("#activities").html('');
                    for (i in data) {
                        var start = moment.unix(data[i].start);
                        var end = moment.unix(data[i].end);
                        if (start.format('DD-MM') == end.format('DD-MM')) {
                            var time = start.format("DD-MM, HH:mm") + ' - ' + end.format("HH:mm");
                        } else {
                            var time = start.format("DD-MM, HH:mm") + ' - ' + end.format("DD-MM, HH:mm");
                        }
                        $("#activities").append('<div class="activity ' + (data[i].current ? "current" : (data[i].over ? "past" : "")) + '">' + time + ' @ ' + data[i].location + '<br><strong>' + data[i].title + '</strong></div>');
                    }
                } else {
                    $("#activities").html('<div class="notice">No upcoming activities!</div>');
                }
                setTimeout(updateActivities, 60000);
            },
            error: function () {
                $("#activities").html('<div class="notice">Something went wrong during retrieval...</div>');
                setTimeout(updateActivities, 5000);
            }
        })
    }

    updateActivities();

    function updateBuses() {
        updateBus('bushalte-ut-hallenweg', '#businfo-hallen');
        updateBus('bushalte-westerbegraafplaats-ut', '#businfo-wester');
    }

    function updateBus(stop, element) {
        $.ajax({
            url: "{{ urldecode(route('api::bus',['stop' => '--replaceme--'])) }}".replace('--replaceme--', stop),
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $(element).html('');
                    console.log(data);
                    for (i in data) {
                        $(element).append('<div class="busentry">' + data[i].time + ' ' + data[i].mode.name + ' ' + data[i].service + ' <span style="color: #c1ff00;">' + (data[i].realtimeText !== null ? data[i].realtimeText + ' (' + data[i].realtimeState + ')' : '(' + data[i].realtimeState + ')') + '</span><br>Towards ' + data[i].destinationName + '</div>');
                    }
                } else {
                    $(element).html('<div class="notice">No buses!</div>');
                }
            },
            error: function () {
                $(element).html('<div class="notice">Error...</div>');
            }
        })
    }

    updateBuses();
    setInterval(updateBuses, 60000);

    function updateBoardroom() {
        $.ajax({
            url: '{{ route('api::timetable::boardroom') }}',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    var count = 0;
                    $("#boardroom-timetable").html('');
                    var occupied = false;
                    for (i in data) {
                        if (data[i].over) {
                            continue;
                        }

                        count++;

                        var start = moment.unix(data[i].start);
                        var end = moment.unix(data[i].end);

                        var day = start.format("dddd");
                        var time = start.format("HH:mm") + ' - ' + end.format("HH:mm");

                        if (data[i].current) {
                            occupied = true;
                        }

                        $("#boardroom-timetable").append('' +
                            '<div class="activity ' + (data[i].current ? "current" : (data[i].over ? "past" : "")) + '">' +
                            '<div class="pull-left" style="width: 125px;"><strong>' + day + '</strong></div>' +
                            time +
                            '<div class="pull-right"><strong>' + data[i].title + '</strong></div>' +
                            '</div>');
                        $("#boardroom__status").html(occupied ? 'Occupied' : 'Available');
                    }
                    if (count == 0) {
                        $("#timetable").html('<div class="notice">No reservations in the next 7 days!</div>');
                    }
                } else {
                    $("#boardroom-timetable").html('<div class="notice">No reservations today!</div>');
                }
                setTimeout(updateBoardroom, 60000);
            },
            error: function () {
                $("#boardroom-timetable").html('<div class="notice">Something went wrong during retrieval...</div>');
                setTimeout(updateBoardroom, 5000);
            }
        })
    }

    updateBoardroom();

    function updateProtopeners() {
        $.ajax({
            url: '{{ route('api::timetable::protopeners') }}',
            dataType: 'json',
            success: function (data) {
                var protopener = null;
                if (data.length > 0) {
                    for (i in data) {
                        if (data[i].current) {
                            protopener = data[i].title
                        }
                    }
                }
                if (protopener !== null) {
                    $("#protopener").html('Your current Protopener is ' + protopener);
                } else {
                    $("#protopener").html('Nobody is Protopening right now. 😞');
                }
                setTimeout(updateProtopeners, 60000);
            },
            error: function () {
                $("#activities").html('<div class="notice">Something went wrong during retrieval...</div>');
                setTimeout(updateProtopeners, 5000);
            }
        })
    }

    updateProtopeners();

    // ProTube
    var screen = io('{!! env('HERBERT_SERVER') !!}/protube-screen');
    var nowplaying;

    screen.on("connect", function () {

        screen.emit("screenReady");

        $("#protube-title").removeClass('active').html("ProTube connected");
        $("#protube-ticker").css("width", "100%");
        $("#protube").addClass('inactive').css("background-image", "auto");

    });

    screen.on("progress", function (data) {

        var progress = parseInt(data);
        $("#protube-ticker").css("width", (data.duration / progress) + "%");

    });

    screen.on("ytInfo", function (data) {

        nowplaying = data;
        if (typeof data.title == "undefined") {
            $("#protube-title").html("📺 ProTube Idle");
            $("#protube-ticker").css("width", "100%");
            $("#protube").addClass('inactive').css("background-image", "auto");
        } else {
            var url = "url('https://i.ytimg.com/vi/" + data.id + "/hqdefault.jpg')";
            $("#protube-ticker").css("width", "0%");
            $("#protube-title").html(data.title);
            $("#protube").removeClass('inactive').css("background-image", url);
        }

    });

    screen.on("disconnect", function () {

        $("#protube-title").html("Connection lost");
        $("#protube-ticker").css("width", "100%");
        $("#protube").addClass('inactive').css("background-image", "auto");

    });

    screen.on("reconnect", function () {

        screen.emit("screenReady");

        $("#protube-title").html("ProTube connected");
        $("#protube-ticker").css("width", "100%");
        $("#protube").addClass('inactive').css("background-image", "auto");

    });


</script>

</body>

</html>
