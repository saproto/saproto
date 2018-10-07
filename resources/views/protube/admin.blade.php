@extends('website.layouts.default')

@section('page-title')
    Protube Admin
@endsection

@section('content')

    <div id="connecting">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-body" style="text-align: center;">
                    <br>
                    <h3>Connecting...</h3>
                </div>
            </div>
        </div>
    </div>

    <div id="no_admin">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body" style="text-align: center;">
                    <br>
                    <h3>Could not connect to ProTube admin!</h3>
                    Very probably something went wrong. Please log-out, log-in and try again.
                </div>
            </div>
        </div>
    </div>

    <div id="connected">

        <div class="col-md-4">

            <div class="panel panel-default">
                <div class="panel-heading">ProTube control</div>
                <div class="panel-body">
                    <table class="table">
                        <tr style="height:60px;">
                            <td style="vertical-align:middle;">YouTube</td>
                            <td style="vertical-align:middle;"><input class="slider" id="youtubeV" data-slider-id="youtubeVSlider" type="text"
                                       data-slider-min="0" data-slider-max="100" data-slider-step="1"/></td>
                        </tr>
                        <tr style="height:60px;">
                            <td style="vertical-align:middle;">Radio</td>
                            <td style="vertical-align:middle;"><input class="slider" id="radioV" data-slider-id="radioVSlider" type="text"
                                       data-slider-min="0" data-slider-max="100" data-slider-step="1"/></td>
                        </tr>
                        <tr style="height:60px;">
                            <td style="vertical-align:middle;">Sounds</td>
                            <td style="vertical-align:middle;"><input class="slider" id="soundboardV" data-slider-id="soundboardVSlider" type="text"
                                       data-slider-min="0" data-slider-max="100" data-slider-step="1"/></td>
                        </tr>
                    </table>
                    <div class="btn-group" role="group" style="width: 100%">
                        <div class="btn-group" role="group" style="width: 50%;">
                            <button type="button" class="btn btn-default" id="protubeToggle" id="protubeToggle" style="width: 100%;">...
                            </button>
                        </div>
                        <div class="btn-group" role="group" style="width: 50%;">
                            <button type="button" class="btn btn-default" id="shuffleRadio" style="width: 80%;"><i class="fa fa-random"
                                                                                               aria-hidden="true"></i>
                                Radio
                            </button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 20%;">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" id="radiostationDropdown">
                                <li><a href="#">Loading...</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">ProTube<span id="currentPin" style="float: right;">...</span></div>
                <div class="panel-body">
                    <div class="btn-group btn-group-justified" role="group" aria-label="ProTube controls">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" id="skip">
                                <i class="fa fa-fast-forward" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" id="playpause">
                                ?
                            </button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" id="reload">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" id="togglephotos">
                                <i class="fa fa-youtube-play" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div id="nowPlaying">
                        <!-- Filled by JS -->
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Soundboard</div>
                <div class="panel-body">


                    @foreach($sounds as $sound)

                        <button type="button" class="btn btn-default soundboard" rel="{{ $sound->id }}">{{ $sound->name }}</button>

                    @endforeach


                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Search</div>
                <div class="panel-body">
                    <form id="searchForm">
                        <div class="form-group" width="100%">
                            <div class="input-group">
                                <div class="input-group-addon"><label for="showVideo"><i class="fa fa-eye"
                                                                                         aria-hidden="true"></i></label>
                                    <input type="checkbox" id="showVideo" checked="checked"></div>
                                <input type="text" class="form-control" id="searchBox" placeholder="Search YouTube...">
                                <div class="input-group-addon" id="clearSearch">x</div>
                            </div>
                        </div>
                    </form>
                    <div id="searchResults"></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Queue</div>
                <div class="panel-body">
                    <div id="queue"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Protopolis control</div>
                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Waving light</h3>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group btn-group-justified" role="group">
                                <a class="btn btn-default lampOn" href="#" rel="18">On</a>
                                <a class="btn btn-default lampOff" href="#" rel="18">Off</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Disco light</h3>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group btn-group-justified" role="group">
                                <a class="btn btn-default lampOn" href="#" rel="2">On</a>
                                <a class="btn btn-default lampOff" href="#" rel="2">Off</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Omnomcom</h3>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group btn-group-justified" role="group">
                                <a class="btn btn-danger" href="#" id="omnomcomReboot">Reboot</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Protube</h3>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group btn-group-justified" role="group">
                                <a class="btn btn-danger" href="#" id="protubeReboot">Reboot</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Screens</div>
                <div class="panel-body" id="protubeScreens">
                    Loading client list...
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Admins</div>
                <div class="panel-body" id="protubeAdmins">
                    Loading client list...
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>
                <div class="panel-body" id="protubeUsers">
                    Loading client list...
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    @parent
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.1.1/bootstrap-slider.min.js"></script>

    <script>
        var server = "{!! config('herbert.server') !!}";
        var token = "{!! Auth::user()->getToken()->token !!}";

        $(document).ready(function () {
            var errorElement = $("body");

            var admin = io(server + '/protube-admin');

            admin.on("connect", function () {
                admin.emit("authenticate", token);
            });

            // On disconnect, hide admin and show connecting screen
            admin.on("disconnect", function () {
                $("#connected").hide(0);
                $("#connecting").show(0);
            });

            // On connect, hide connecting screen and show admin
            admin.on("authenticated", function (data) {
                $("#connecting").hide(0);
                $("#connected").show(0);
            });

            // On connect, hide connecting screen and show admin
            admin.on("no_admin", function (data) {
                $("#connecting").hide(0);
                $("#no_admin").show(0);
            });

            // Initialize volume sliders.
            $("#youtubeV").slider().on("slideStop", function (event) {
                admin.emit("setYoutubeVolume", event.value);
            });
            $("#radioV").slider().on("slideStop", function (event) {
                admin.emit("setRadioVolume", event.value);
            });
            $("#soundboardV").slider().on("slideStop", function (event) {
                admin.emit("setSoundboardVolume", event.value);
            });


            admin.on("queue", function (data) {
                var queue = $("#queue");
                queue.html("");

                for (var i in data) {
                    var controls = "";
                    if (i > 0) controls += '<span class="up" data-index="' + i + '"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></span>';
                    if (i < data.length - 1) controls += '<span class="down" data-index="' + i + '"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>';
                    controls += '<span class="veto" data-index="' + i + '"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>';

                    queue.append('<div class="item" data-ytId="' + data[i].id + '">' +
                        '<img src="//img.youtube.com/vi/' + data[i].id + '/0.jpg" />' +
                        '<div class="time">' + prettifyDuration(data[i].duration) + '</div>' +
                        '<div>' +
                        '<h1>' + data[i].title + '</h1>' +
                        '<h2>added by ' + (data[i].name ? data[i].name : 'anonymous') + '</h2>' +
                        '<h3>' + controls + '</h3>' +
                        '</div>' +
                        '<div style="clear: both;"></div>' +
                        '</div>');
                }

                $(".up").click(function (e) {
                    e.preventDefault();
                    moveQueueItem($(this).attr("data-index"), 'up');
                });

                $(".down").click(function (e) {
                    e.preventDefault();
                    moveQueueItem($(this).attr("data-index"), 'down');
                });

                $(".veto").click(function (e) {
                    e.preventDefault();
                    admin.emit("veto", $(this).attr("data-index"));
                });
            });

            function moveQueueItem(index, direction) {

                var data = {
                    'index': index,
                    'direction': direction
                };

                admin.emit("move", data);
            }

            admin.on("ytInfo", function (data) {
                if (!$.isEmptyObject(data)) {
                    $("#nowPlaying").html('<img src="//img.youtube.com/vi/' + data.id + '/0.jpg" width="100px" class="pull-left img-thumbnail" />' +
                        '<h1>' + data.title + '</h1>' +
                        '<h2>added by ' + (data.name ? data.name : 'anonymous') + '</h2>' +
                        '<div style="clear: both; margin-top: 15px; text-align: center;"><strong id="current_time">0:00</strong> <input class="slider" id="progress" data-slider-id="progressSlider" type="text" data-slider-min="0" data-slider-max="' + data.duration +
                        '" data-slider-step="1" data-slider-value="' + data.progress + '"/> <strong>' + prettifyDuration(data.duration) + '</strong></div>');
                    $("#progress").slider({
                        formatter: function (value) {
                            return prettifyDuration(value);
                        }
                    }).on("slideStop", function (event) {
                        admin.emit("setTime", event.value);
                    });
                } else {
                    $("#nowPlaying").html("");
                }
            });

            admin.on("progress", function (data) {
                $("#progress").slider('setValue', data);
                $("#current_time").html(prettifyDuration(data));
            });

            admin.on("pin", function (data) {
                $("#currentPin").html("PIN: " + data);
            });

            admin.on("playerState", function (data) {
                if (data.slideshow) {
                    $("#togglephotos").html('<i class="fa fa-youtube-play" aria-hidden="true"></i>');
                } else {
                    $("#togglephotos").html('<i class="fa fa-picture-o" aria-hidden="true"></i>');
                }
                if (data.playing) {
                    if (data.paused) {
                        $("#playpause").html('<i class="fa fa-play" aria-hidden="true"></i>');
                    } else {
                        $("#playpause").html('<i class="fa fa-pause" aria-hidden="true"></i>');
                    }
                    $("#skip").html('<i class="fa fa-fast-forward" aria-hidden="true"></i>');
                } else {
                    $("#playpause").html('<i class="fa fa-ellipsis-h" aria-hidden="true"></i>');
                    $("#togglephotos").html('<i class="fa fa-ellipsis-h" aria-hidden="true"></i>');
                    $("#skip").html('<i class="fa fa-ellipsis-h" aria-hidden="true"></i>');
                }
                if (data.protubeOn) {
                    $("#protubeToggle").html('<i class="fa fa-toggle-on" aria-hidden="true"></i> ProTube');
                } else {
                    $("#protubeToggle").html('<i class="fa fa-toggle-off" aria-hidden="true"></i> ProTube');
                }
            });


            $('#searchForm').bind('submit', function (e) {
                e.preventDefault();
                admin.emit("search", $("#searchBox").val());
                $("#results").html("Loading...");
            });

            admin.on("searchResults", function (data) {
                var results = $("#searchResults");

                results.html("");

                for (var i in data) {
                    results.append(generateResult(data[i]));
                }

                $(".result").each(function (i) {
                    var current = $(this);
                    current.click(function (e) {
                        e.preventDefault();
                        admin.emit("add", {
                            id: current.attr("ytId"),
                            showVideo: ($("#showVideo").prop("checked") ? true : false)
                        });
                    });
                });

                results.show(100);
            });

            admin.on("clients", function (data) {
                $("#protubeScreens").html("");
                $("#protubeAdmins").html("");
                $("#protubeUsers").html("");
                for (var i in data) {
                    var client = data[i];
                    switch (client.type) {
                        case'screen':
                            $("#protubeScreens").append("<p>Connection from <strong>" + client.network + "</strong></p>")
                            break;
                        case'admin':
                            $("#protubeAdmins").append("<p><strong>" + client.name + "</strong><br><sup>Connection from " + client.network + "</sup></p>")
                            break;
                        case 'remote':
                            $("#protubeUsers").append("<p><strong>" + client.name + "</strong><br><sup>Connection from " + client.network + "</sup></p>")
                            break;
                    }

                }
            });

            admin.on("radiostations", function(data) {
                var stationsHtml = "";

                for (var i in data) {
                    var station = data[i];

                    stationsHtml += "<li><a href='#' data-id=" + i + ">" + station.name + "</a></li>";
                }

                $("#radiostationDropdown").html(stationsHtml);

                $("#radiostationDropdown li a").each(function() {
                    $(this).click(function(e) {
                        e.preventDefault();

                        admin.emit("setRadio", $(this).attr('data-id'));
                    })
                })
            });

            $("#clearSearch").click(function (e) {
                e.preventDefault();
                $("#searchResults").hide(0);
                $("#searchBox").val("");
            });

            $("#playpause").click(function (e) {
                e.preventDefault();
                admin.emit("pause");
            });

            $("#skip").click(function (e) {
                e.preventDefault();
                admin.emit("skip");
            });

            $("#reload").click(function (e) {
                e.preventDefault();
                admin.emit("fullReload");
            });

            $("#togglephotos").click(function (e) {
                e.preventDefault();
                admin.emit("togglePhotos");
            });

            $("#protubeToggle").click(function (e) {
                e.preventDefault();
                admin.emit("protubeToggle");
            });

            $("#shuffleRadio").click(function (e) {
                e.preventDefault();
                admin.emit("shuffleRadio");
            });

            $(".soundboard").click(function (e) {
                e.preventDefault();
                admin.emit("soundboard", $(this).attr("rel"));
            });

            $(".lampOn").click(function (e) {
                e.preventDefault();
                admin.emit("lampOn", $(this).attr("rel"));
            });

            $(".lampOff").click(function (e) {
                e.preventDefault();
                admin.emit("lampOff", $(this).attr("rel"));
            });

            $("#omnomcomReboot").click(function (e) {
                e.preventDefault();
                if(confirm('Are you sure you want to restart the Omnomcom?')) admin.emit("omnomcomReboot");
            });

            $("#protubeReboot").click(function (e) {
                e.preventDefault();
                if(confirm('Are you sure you want to restart the Protube system?')) admin.emit("protubeReboot");
            });

            admin.on("volume", function (data) {
                $("#youtubeV").slider('setValue', data.youtube);
                $("#radioV").slider('setValue', data.radio);
                $("#soundboardV").slider('setValue', data.soundboard);
            });
        });

        function generateResult(item) {
            var result = '<div class="result" ytId="' + item.id + '">' +
                '<img src="//img.youtube.com/vi/' + item.id + '/0.jpg" />' +
                '<div>' +
                '<h1>' + item.title + '</h1>' +
                '<h2>' + item.channelTitle + '</h2>' +
                '<h3>' + item.duration + '</h3>' +
                '</div>' +
                '<div style="clear: both;"></div>' +
                '</div>';

            return result;
        }

        // Based on //stackoverflow.com/questions/3733227/javascript-seconds-to-minutes-and-seconds
        function prettifyDuration(time) {
            var minutes = Math.floor(time / 60);
            var seconds = time - minutes * 60;

            function str_pad_left(string, pad, length) {
                return (new Array(length + 1).join(pad) + string).slice(-length);
            }

            var finalTime = str_pad_left(minutes, '0', 2) + ':' + str_pad_left(seconds, '0', 2);

            return finalTime;
        }
    </script>
@endsection

@section('stylesheet')

    @parent
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.1.1/css/bootstrap-slider.min.css">

    <style>
        #connected {
            display: none;
            margin-top: 20px;
        }

        #no_admin {
            display: none;
        }

        #progressSlider {
            width: 65%;
        }

        #progressSlider .slider-selection {
            background: #BABABA;
        }

        #nowPlaying {
            margin-top: 10px;
        }

        #nowPlaying h1 {
            padding: 0;
            margin: 10px 0;
            font-size: 18px;
        }

        #nowPlaying h2 {
            padding: 0;
            margin: 2% 0;
            font-size: 12px;
        }

        #nowPlaying img {
            margin-right: 10px;
        }

        #clearSearch:hover {
            background-color: #ddd;
            cursor: pointer;
        }

        #searchResults {
            display: none;
            height: 200px;
            overflow-y: scroll;
        }

        #searchResults .result:hover {
            cursor: pointer;
            background-color: #eee;
        }

        #searchResults .result img {
            width: 100px;
            float: left;
            margin-right: 10px;
        }

        #searchResults .result h1 {
            font-size: 16px;
            margin: 5px 0;
        }

        #searchResults .result h2 {
            font-size: 12px;
            margin: 2px 0;
        }

        #searchResults .result h3 {
            font-size: 10px;
            margin: 0;
        }

        #queue {
        }

        #queue .item {
            position: relative;
        }

        #queue .item:hover {
            background-color: #eee;
        }

        #queue .item img {
            width: 100px;
            height: 75px;
            float: left;
            top: 0px;
            left: 0px;
        }

        #queue .item .time {
            position: absolute;
            left: 0px;
            top: 50px;
            font-size: 10px;
            color: #ffffff;
            background-color: #000;
            padding: 5px;
        }

        #queue .item div {
            position: relative;
            left: 10px;
        }

        #queue .item h1 {
            font-size: 16px;
            margin: 0;
        }

        #queue .item h2 {
            font-size: 12px;
            margin: 2px 0;
        }

        .soundboard {
            width: 48%;
        }
    </style>
@endsection
