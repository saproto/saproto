<html>
<head>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />

    <link rel="stylesheet" href="http://saproto:8888/assets/application.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.1.1/css/bootstrap-slider.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>

    <script src="http://saproto:8888/assets/application.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.1.1/bootstrap-slider.min.js"></script>

    <style>
        body {
            background: #eee;
        }

        #connected {
            display: none;
            margin-top: 20px;
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

        #queue .item:hover {
            cursor: pointer;
            background-color: #eee;
        }

        #queue .item img {
            width: 100px;
            float: left;
            margin-right: 10px;
        }

        #queue .item h1 {
            font-size: 16px;
            margin: 5px 0;
        }

        #queue .item h2 {
            font-size: 12px;
            margin: 2px 0;
        }
    </style>

    <script>
        var server = "{!! env('HERBERT_SERVER') !!}";
        var token = "{!! Session::get('token') !!}";

        $(document).ready(function() {
            var errorElement = $("body");

            var admin = io(server + '/protube-admin');

            admin.emit("authenticate", token);

            admin.on("authenticated", function(data) {
                // Initialize volume sliders.
                $("#youtubeV").slider().on("slideStop", function(event) {
                    admin.emit("setYoutubeVolume", event.value);
                });
                $("#radioV").slider().on("slideStop", function(event) {
                    admin.emit("setRadioVolume", event.value);
                });

                // On connect, hide connecting screen and show admin
                $("#connecting").hide(0);
                $("#connected").show(0);

                // On reconnect, hide connecting screen and show admin
                admin.on("reconnect", function() {
                    $("#connecting").hide(0);
                    $("#connected").show(0);
                });

                // On disconnect, hide admin and show connecting screen
                admin.on("disconnect", function() {
                    $("#connected").hide(0);
                    $("#connecting").show(0);
                });

                admin.on("queue", function(data) {
                    var queue = $("#queue");
                    queue.html("");

                    for(var i in data) {
                        var controls = "";
                        if(i > 0) controls += '<span class="up" data-index="' + i + '"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></span>';
                        if(i < data.length-1) controls += '<span class="down" data-index="' + i + '"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>';
                        controls += '<span class="veto" data-index="' + i + '"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>';

                        queue.append('<div class="item" data-ytId="' + data[i].id + '">' +
                                '<img src="http://img.youtube.com/vi/' + data[i].id + '/0.jpg" />' +
                                '<div>' +
                                '<h1>' + data[i].title + '</h1>' +
                                '<h2>' + prettifyDuration(data[i].duration ) + '</h2>' +
                                '<h3>' + controls + '</h3>' +
                                '</div>' +
                                '<div style="clear: both;"></div>' +
                                '</div>');
                    }

                    $(".up").click(function(e) {
                        e.preventDefault();
                        moveQueueItem($(this).attr("data-index"), 'up');
                    });

                    $(".down").click(function(e) {
                        e.preventDefault();
                        moveQueueItem($(this).attr("data-index"), 'down');
                    });

                    $(".veto").click(function(e) {
                        e.preventDefault();
                        admin.emit("veto", $(this).attr("data-index"));
                    });
                });

                function moveQueueItem(index, direction) {

                    var data = {
                        'index' : index,
                        'direction' : direction
                    };

                    admin.emit("move", data);
                }

                admin.on("ytInfo", function(data) {
                    if(!$.isEmptyObject(data)) {
                        $("#nowPlaying").html('<img src="http://img.youtube.com/vi/' + data.id + '/0.jpg" width="100px" class="pull-left img-thumbnail" />' +
                                '<h1>' + data.title + '</h1>' +
                                '<strong>0:00</strong> <input class="slider" id="progress" data-slider-id="progressSlider" type="text" data-slider-min="0" data-slider-max="' + data.duration +
                                '" data-slider-step="1" data-slider-value="' + data.progress + '"/> <strong>'+ prettifyDuration(data.duration) +'</strong>');
                        $("#progress").slider({
                            formatter: function(value) {
                                return prettifyDuration(value);
                            }
                        }).on("slideStop", function(event) {
                            admin.emit("setTime", event.value);
                        });
                    }else{
                        $("#nowPlaying").html("");
                    }
                });

                admin.on("progress", function(data) {
                    $("#progress").slider('setValue', data);
                });

                $('#searchForm').bind('submit', function(e){
                    e.preventDefault();
                    admin.emit("search", $("#searchBox").val());
                    $("#results").html("Loading...");
                });

                admin.on("searchResults", function(data) {
                    var results = $("#searchResults");

                    results.html("");

                    for(var i in data) {
                        results.append(generateResult(data[i]));
                    }

                    $(".result").each(function(i) {
                        var current = $(this);
                        current.click(function(e) {
                            e.preventDefault();
                            admin.emit("add", {
                                id: current.attr("ytId"),
                                showVideo: ($("#showVideo").prop("checked") ? true : false)
                            });
                        });
                    });

                    results.show(100);
                });

                $("#clearSearch").click(function(e) {
                    e.preventDefault();
                    $("#searchResults").hide(0);
                    $("#searchBox").val("");
                });

                $("#playpause").click(function(e) {
                    e.preventDefault();
                    admin.emit("pause");
                });

                $("#skip").click(function(e) {
                    e.preventDefault();
                    admin.emit("skip");
                });

                $("#reload").click(function(e) {
                    e.preventDefault();
                    admin.emit("reload");
                });

                admin.on("volume", function(data) {
                    $("#youtubeV").slider('setValue', data.youtube);
                    $("#radioV").slider('setValue', data.radio);
                });
            });
        });

        function generateResult(item) {
            var result = '<div class="result" ytId="' + item.id + '">' +
                    '<img src="http://img.youtube.com/vi/' + item.id + '/0.jpg" />' +
                    '<div>' +
                    '<h1>' + item.title + '</h1>' +
                    '<h2>' + item.channelTitle +  '</h2>' +
                    '<h3>' + item.duration + '</h3>' +
                    '</div>' +
                    '<div style="clear: both;"></div>' +
                    '</div>';

            return result;
        }

        // Based on http://stackoverflow.com/questions/3733227/javascript-seconds-to-minutes-and-seconds
        function prettifyDuration(time) {
            var minutes = Math.floor(time / 60);
            var seconds = time - minutes * 60;

            function str_pad_left(string,pad,length) {
                return (new Array(length+1).join(pad)+string).slice(-length);
            }

            var finalTime = str_pad_left(minutes,'0',2)+':'+str_pad_left(seconds,'0',2);

            return finalTime;
        }
    </script>


    <title>Admin</title>
</head>

<body>

<div id="connecting" class="container">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">Connecting...</div>
        </div>
    </div>
</div>


<div id="connected" class="container">

    <div class="col-md-4">

        <div class="panel panel-default">
            <div class="panel-heading">Volume control</div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>YouTube</td>
                        <td><input class="slider" id="youtubeV" data-slider-id="youtubeVSlider" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" /></td>
                    </tr>
                    <tr>
                        <td>Radio</td>
                        <td><input class="slider" id="radioV" data-slider-id="radioVSlider" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" /></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">ProTube</div>
            <div class="panel-body">
                <div class="btn-group btn-group-justified" role="group" aria-label="ProTube controls">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="skip">Skip</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="playpause">Play / Pause</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="reload">Reload</button>
                    </div>
                </div>
                <div id="nowPlaying">
                    <!-- Filled by JS -->
                </div>
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
                            <div class="input-group-addon"><label for="showVideo"><i class="fa fa-eye" aria-hidden="true"></i></label>
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
            <div class="panel-heading">Active sessions</div>
            <div class="panel-body">...</div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Omnomcom</div>
            <div class="panel-body">...</div>
        </div>
    </div>
</div>

</body>
</html>