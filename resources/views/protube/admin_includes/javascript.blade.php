@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        let server = "{!! config('protube.server') !!}";
        let token = "{!! Auth::user()->getToken()->token !!}";

        $(function () {
            let errorElement = $("body");

            let admin = io(server + '/protube-admin');

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
                let queue = $("#queue");
                queue.html("");

                if (data.length > 0) {
                    $("#queueDefault").hide();
                    queue.show();
                } else {
                    $("#queueDefault").show();
                    queue.hide();
                }

                for (let i in data) {
                    let controls = ['veto'];
                    if (i > 0) controls.push('up');
                    if (i < data.length - 1) controls.push('down');

                    queue.append(generateResult(data[i], {'type': 'queue', 'controls': controls, 'i': i}));
                }

                $(".up").on("click", function (e) {
                    e.preventDefault();
                    moveQueueItem($(this).attr("data-index"), 'up');
                });

                $(".down").on("click", function (e) {
                    e.preventDefault();
                    moveQueueItem($(this).attr("data-index"), 'down');
                });

                $(".veto").on("click", function (e) {
                    e.preventDefault();
                    admin.emit("veto", $(this).attr("data-index"));
                });
            });

            function moveQueueItem(index, direction) {

                let data = {
                    'index': index,
                    'direction': direction
                };

                admin.emit("move", data);
            }

            admin.on("ytInfo", function (data) {

                if (!$.isEmptyObject(data)) {

                    $("#nowPlayingDefault").hide();

                    $("#nowPlaying").show().html("").append(generateResult(data, {'type': 'nowPlaying'}))
                        .append('<hr><div class="row">' +
                            '<div class="col-3 text-end">' +
                            '<strong id="current_time">0:00</strong>' +
                            '</div>' +
                            '<div class="col-6">' +
                            '<input class="slider" id="progress" data-slider-id="progressSlider" type="text" data-slider-min="0" data-slider-max="' + data.duration + '" data-slider-step="1" data-slider-value="' + data.progress + '">' +
                            '</div>' +
                            '<div class="col-3 text-left">' +
                            '<strong>' + prettifyDuration(data.duration) + '</strong>' +
                            '</div>' +
                            '</div>'
                        );

                    $("#progress").slider({
                        formatter: function (value) {
                            return prettifyDuration(value);
                        }
                    }).on("slideStop", function (event) {
                        admin.emit("setTime", event.value);
                    });

                } else {

                    $("#nowPlaying").hide();
                    $("#nowPlayingDefault").show();

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
                    $("#togglephotos").html('<i class="fab fa-youtube" aria-hidden="true"></i>');
                } else {
                    $("#togglephotos").html('<i class="fas fa-images" aria-hidden="true"></i>');
                }
                if (data.playing) {
                    if (data.paused) {
                        $("#playpause").html('<i class="fas fa-play" aria-hidden="true"></i>');
                    } else {
                        $("#playpause").html('<i class="fas fa-pause" aria-hidden="true"></i>');
                    }
                    $("#skip").html('<i class="fas fa-fast-forward" aria-hidden="true"></i>');
                } else {
                    $("#playpause").html('<i class="fas fa-minus" aria-hidden="true"></i>');
                    $("#togglephotos").html('<i class="fas fa-minus" aria-hidden="true"></i>');
                    $("#skip").html('<i class="fas fa-minus" aria-hidden="true"></i>');
                }
                if (data.protubeOn) {
                    $("#protubeToggle").addClass('btn-primary').removeClass('btn-warning btn-dark')
                        .html('<i class="fas fa-toggle-on" aria-hidden="true"></i> ProTube');
                } else {
                    $("#protubeToggle").addClass('btn-warning').removeClass('btn-primary btn-dark')
                        .html('<i class="fas fa-toggle-off" aria-hidden="true"></i> ProTube');
                }
            });


            $('#searchForm').on('bind', 'submit', function (e) {
                e.preventDefault();
                admin.emit("search", $("#searchBox").val());
                $("#searchResults > div").html("<p class='text-center card-text'><i class='fas fa-spinner fa-spin me-2'></i> Searching...</p>");
            });

            admin.on("searchResults", function (data) {
                let results = $("#searchResults > div");

                $("#searchResultsDefault").hide();
                results.html("");

                for (let i in data) {
                    results.append(generateResult(data[i], {'type': 'result'}));
                }

                $(".result").each(function (i) {
                    let current = $(this);
                    current.click(function (e) {
                        e.preventDefault();
                        admin.emit("add", {
                            id: current.attr("ytId"),
                            showVideo: ($("#showVideo > i:first-child").hasClass("fa-youtube") ? true : false)
                        });
                    });
                });

                results.show(100);
            });

            admin.on("clients", function (data) {
                $("#protubeScreens > li").not(":first").remove();
                $("#protubeAdmins > li").not(":first").remove();
                $("#protubeUsers > li").not(":first").remove();
                for (let i in data) {
                    let client = data[i];
                    switch (client.type) {
                        case'screen':
                            $("#protubeScreens > li:first-child").after("<li class='list-group-item'>Connection from <strong>" + client.network + "</strong></li>")
                            break;
                        case'admin':
                            $("#protubeAdmins > li:first-child").after("<li class='list-group-item'><strong>" + client.name + "</strong><br>Connection from " + client.network + "</li>")
                            break;
                        case 'remote':
                            $("#protubeUsers > li:first-child").after("<li class='list-group-item'><strong>" + client.name + "</strong><br>Connection from " + client.network + "</li>")
                            break;
                    }

                }
            });

            admin.on("radiostations", function (data) {
                let stationsHtml = "";

                for (let i in data) {
                    let station = data[i];

                    stationsHtml += "<a class='dropdown-item' href='javascript:void();' data-id=" + i + ">" + station.name + "</a>";
                }

                $("#radiostationDropdown").html(stationsHtml);

                $("#radiostationDropdown a").each(function () {
                    $(this).on("click", function (e) {
                        e.preventDefault();

                        admin.emit("setRadio", $(this).attr('data-id'));
                    })
                })
            });

            $("#clearSearch").on("click", function (e) {
                e.preventDefault();
                $("#searchResultsDefault").show();
                $("#searchResults > div").html("");
                $("#searchBox").val("");
            });

            $("#playpause").on("click", function (e) {
                e.preventDefault();
                admin.emit("pause");
            });

            $("#skip").on("click", function (e) {
                e.preventDefault();
                admin.emit("skip");
            });

            $("#reload").on("click", function (e) {
                e.preventDefault();
                admin.emit("fullReload");
            });

            $("#togglephotos").on("click", function (e) {
                e.preventDefault();
                admin.emit("togglePhotos");
            });

            $("#protubeToggle").on("click", function (e) {
                e.preventDefault();
                admin.emit("protubeToggle");
            });

            $("#shuffleRadio").on("click", function (e) {
                e.preventDefault();
                admin.emit("shuffleRadio");
            });

            $(".soundboard").on("click", function (e) {
                e.preventDefault();
                admin.emit("soundboard", $(this).attr("rel"));
            });

            $(".lampOn").on("click", function (e) {
                e.preventDefault();
                admin.emit("lampOn", $(this).attr("rel"));
            });

            $(".lampOff").on("click", function (e) {
                e.preventDefault();
                admin.emit("lampOff", $(this).attr("rel"));
            });

            $("#omnomcomReboot").on("click", function (e) {
                e.preventDefault();
                if (confirm('Are you sure you want to restart the Omnomcom?')) admin.emit("omnomcomReboot");
            });

            $("#protubeReboot").on("click", function (e) {
                e.preventDefault();
                if (confirm('Are you sure you want to restart the Protube system?')) admin.emit("protubeReboot");
            });

            $("#showVideo").on("click", function () {
                $("#showVideo > i").toggleClass('fab fa-youtube fas fa-images');
            });

            admin.on("volume", function (data) {
                $("#youtubeV").slider('setValue', data.youtube);
                $("#radioV").slider('setValue', data.radio);
                $("#soundboardV").slider('setValue', data.soundboard);
            });
        });

        function generateResult(item, opts) {

            let result = '<div class="row mb-1 p-2 video ' + (opts.type === 'result' ? 'result' : '') + '" ytId="' + item.id + '" style="cursor: pointer;">' +
                '<div class="col-3">' +
                '<img style="max-width: 100%;" src="//img.youtube.com/vi/' + item.id + '/0.jpg" />' +
                '</div>' +
                '<div class="col-9">';

            if (opts.type === 'queue') {
                result = result + '<div class="float-end" style="font-size: 1.15rem;">' +
                    '<i class="fas fa-fw ' + (opts.controls.indexOf('down') >= 0 ? 'fa-caret-square-down down' : 'text-muted') + '" data-index="' + opts.i + '"></i>' +
                    '<i class="fas fa-fw ' + (opts.controls.indexOf('veto') >= 0 ? 'fa-minus-square veto' : 'text-muted') + '" data-index="' + opts.i + '"></i>' +
                    '<i class="fas fa-fw ' + (opts.controls.indexOf('up') >= 0 ? 'fa-caret-square-up up' : 'text-muted') + '" data-index="' + opts.i + '"></i>' +
                    '</div>';
            }

            result = result + '<strong>' + item.title + '</strong><br>';

            if (typeof item.channelTitle !== "undefined") {
                result = result + item.channelTitle + '<br>';
            }
            if (typeof item.callingName !== "undefined") {
                result = result + 'Added by ' + (item.callingName ? item.callingName : 'someone') + '<br>';
            }
            if (typeof item.duration !== "undefined") {
                result = result + '<sup>' + prettifyDuration(item.duration) + '</sup><br>';
            }

            result = result + '</div>';

            return result;

        }

        // Based on //stackoverflow.com/questions/3733227/javascript-seconds-to-minutes-and-seconds
        function prettifyDuration(time) {
            if (typeof time !== 'number') {
                return time;
            }

            let minutes = Math.floor(time / 60);
            let seconds = time - minutes * 60;

            function str_pad_left(string, pad, length) {
                return (new Array(length + 1).join(pad) + string).slice(-length);
            }

            let finalTime = str_pad_left(minutes, '0', 2) + ':' + str_pad_left(seconds, '0', 2);

            return finalTime;
        }
    </script>
@endpush