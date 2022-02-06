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

        html, body, #container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            font-family: Lato, sans-serif;

            padding: 15px 10px;
            margin: 0;

            background-color: #333;
        }

        .green {
            color: #c1ff00;
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

            border-radius: .25rem;

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
            width: 230px;

            overflow: visible;
        }

        #ticker {
            position: absolute;

            bottom: 0;
            left: 0;

            height: 5px;
            width: 100%;

            border-radius: .25rem;

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
            background-color: rgba(255, 255, 255, 0.05);
        }

        .activity.past {
            opacity: 0.5;
        }

        .activity.current {
            color: #c1ff00;
        }

        span.current {
            color: #c1ff00;
            font-weight: bold;
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
            background-image: url('{{ route('api::fishcam') }}') !important;
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

<div id="container" class="row row-eq-height" style="height: 100%;">

    <div class="col-md-4">

        <div class="box-partial" style="height: 100%;">

            <div class="box" style="height: 100%;">

                <div class="box-header">

                    <i class="fas fa-calendar-alt fa-fw mr-2"></i>
                    Timetable

                </div>

                <div id="timetable">

                    <div class="notice">Loading timetable...</div>

                </div>

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

            <div id="protopeners" class="box" style="height: 100%;">

                <div class="box-header small">
                    <i class="fas fa-door-closed fa-fw mr-2" id="protopolis-fa"></i>
                    Protopolis
                </div>

                <div id="protopeners-timetable"></div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="box-partial" style="height: 66.66%;">

            <div class="box" style="height: 100%;">

                <div class="box-header">

                    <i class="fas fa-calendar-alt fa-fw mr-2"></i>
                    Activities

                </div>

                <div id="activities">

                    <div class="notice">Loading activities...</div>

                </div>

            </div>

        </div>

        <div class="box-partial" style="height: 33.33%;">

            <div class="box" style="height: 100%;">

                <div class="row px-4">

                    <div class="col-md-6">

                        <div class="box-header small">
                            <i class="fas fa-bus fa-fw mr-1"></i>
                            Hallenweg
                        </div>

                        <div id="businfo-hallen" class="businfo">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="box-header small">
                            <i class="fas fa-bus fa-fw mr-1"></i>
                            Westerbegraafplaats
                        </div>

                        <div id="businfo-wester" class="businfo">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@include('website.layouts.assets.javascripts')
@stack('javascript')

<script type="text/javascript" nonce="{{ csp_nonce() }}">

    function updateClock() {
        let now = moment();
        $("#clock").html('<i class="fas fa-clock fa-fw mr-2"></i>' + now.format('HH:mm:ss'));
        $("#ticker").css("width", ((now.format('s.SSS') / 60) * 100) + "%");
    }

    setInterval(updateClock, 10);

    function updateTimetable() {
        $.ajax({
            url: '{{ route('api::screen::timetable') }}',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $("#timetable").html('');
                    let count = 0;
                    for (i in data) {
                        if (!data[i].over) {
                            let start = moment.unix(data[i].start);
                            let end = moment.unix(data[i].end);
                            let time = start.format("HH:mm") + ' - ' + end.format("HH:mm");
                            let title = data[i].title;
                            let displayTime = '<i class="fas fa-clock fa-fw mr-1"></i>' + time + ' <span class="float-right"><i class="fas fa-map-marker-alt fa-fw mr-1"></i>' + data[i].place + '</span>';
                            $("#timetable").append('<div class="activity">' +
                                (data[i].studyShort ? '<span class="float-right ml-2">' + '<i class="fas fa-graduation-cap fa-fw mr-2"></i>' + data[i].studyShort + ' ' + (data[i].year ? 'Year ' + data[i].year : '') + '</span> ' : null) +
                                '<strong>' + data[i].type + '</strong><br>' +
                                '<span class="' + (data[i].current ? "current" : "") + '">' + title + '</span>' +
                                '<br>' +
                                displayTime + '' +
                                '</div>'
                            );
                            count++;
                        }
                    }
                    if (count === 0) {
                        $("#timetable").html('<div class="notice">No more lectures today!</div>');
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

    function updateActivities() {
        $.ajax({
            url: '{{ route('api::events::upcoming', ['limit' => 10]) }}',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $("#activities").html('');
                    for (let i in data) {
                        let start = moment.unix(data[i].start);
                        let end = moment.unix(data[i].end);
                        let time;
                        if (start.format('DD-MM') === end.format('DD-MM')) {
                            time = start.format("DD-MM, HH:mm") + ' - ' + end.format("HH:mm");
                        } else {
                            time = start.format("DD-MM, HH:mm") + ' - ' + end.format("DD-MM, HH:mm");
                        }
                        $("#activities").append('<div class="activity ' + (data[i].current ? "current" : (data[i].over ? "past" : "")) + '"><strong>' + data[i].title + '</strong><br><i class="fas fa-clock fa-fw mr-1"></i> ' + time + ' <span class="float-right"><i class="fas fa-map-marker-alt fa-fw mr-1"></i> ' + data[i].location + '</span></div>');
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
        updateBus(43005640, 43005630, '#businfo-hallen');
        updateBus(43005640, 43005630, '#businfo-wester');
    }

    function updateBus(stop, stop_other_side, element) {
        $.ajax({
            url: "{{ urldecode(route('api::screen::bus',['stop' => '43005630', 'other_stop'=>'43005630'])) }}",
            dataType: 'json',
            success: function (data) {
                console.log(Object.keys(data))
                if (Object.keys(data).length > 0) {
                    $(element).html('');

                    let sortableBusses =Object.entries(data).slice(0)
                    sortableBusses.sort(function(a,b) {
                        return ((new Date(a[1].ExpectedArrivalTime).valueOf()) - (new Date(b[1].ExpectedArrivalTime).valueOf()));
                    });
                    for (const [key, value] of sortableBusses) {
                        // let colorLate= (Math.abs(value.ExpectedArrivalTime - value.TargetArrivalTime)/1000*60 < 1) ? '#ff0000':'#ff0000';
                        $(element).append('<div class="busentry">'+ new Date(value.ExpectedArrivalTime).toISOString().substr(11, 8).substr(0,5)+ ' ' + value.TransportType+' '+ value.LinePublicNumber + ' <span style="color: #c1ff00;">' + value.TripStopStatus + '</span><br>Towards ' + value.DestinationName50 + '</div>');
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

    function updateProtopeners() {
        $.ajax({
            url: '{{ route('api::screen::timetable::protopeners') }}',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $("#protopeners-timetable").html('');
                    let open = false;
                    let count = 0;
                    for (let i in data) {
                        if (data[i].over) {
                            continue;
                        } else if (data[i].current) {
                            open = true;
                        }
                        count++;

                        let start = moment.unix(data[i].start);
                        let end = moment.unix(data[i].end);
                        let time = start.format("HH:mm") + ' - ' + end.format("HH:mm");

                        $("#protopeners-timetable").append('' +
                            '<div class="activity ' + (data[i].current ? "current" : "") + '">' +
                            '<div class="float-left">' + time + '</div>' +
                            '<div class="float-right"><strong>' + data[i].title + '</strong></div>' +
                            '</div>');
                    }
                    if (open) {
                        $("#protopolis-fa").addClass('fa-door-open green').removeClass('fa-door-closed');
                    } else {
                        $("#protopolis-fa").removeClass('fa-door-open green').addClass('fa-door-closed');
                    }
                    if (count === 0) {
                        $("#protopeners-timetable").html('<div class="notice">Protopolis closed for today!</div>');
                    }
                } else {
                    $("#protopeners-timetable").html('<div class="notice">Protopolis closed today!</div>');
                }
                setTimeout(updateProtopeners, 60000);
            },
            error: function () {
                $("#protopeners-timetable").html('<div class="notice">Something went wrong during retrieval...</div>');
                setTimeout(updateProtopeners, 5000);
            }
        })
    }

    updateProtopeners();

    // ProTube
    let screen = io('{!! config('herbert.server') !!}/protube-screen');
    let nowplaying;

    screen.on("connect", function () {

        screen.emit("screenReady");

        $("#protube-title").removeClass('active').html("ProTube connected");
        $("#protube-ticker").css("width", "100%");
        $("#protube").addClass('inactive').css("background-image", "auto");

    });

    screen.on("progress", function (data) {

        let progress = parseInt(data);
        $("#protube-ticker").css("width", (data.duration / progress) + "%");

    });

    screen.on("ytInfo", function (data) {

        nowplaying = data;
        if (typeof data.title == "undefined") {
            $("#protube-title").html('<i class="fab fa-youtube fa-fw mr-2"></i> ProTube Idle');
            $("#protube-ticker").css("width", "100%");
            $("#protube").addClass('inactive').css("background-image", "auto");
        } else {
            let url = "url('https://i.ytimg.com/vi/" + data.id + "/hqdefault.jpg')";
            $("#protube-ticker").css("width", "0%");
            $("#protube-title").html('<i class="fab fa-youtube fa-fw mr-2"></i> ' + data.title);
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
