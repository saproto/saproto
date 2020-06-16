<script type="text/javascript" src="{{ asset('assets/application.min.js') }}"></script>

<script type="text/javascript">
    moment.updateLocale('en', {
        week: {dow: 1}
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {

        // Enables tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Enables the fancy scrolling effect
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();

            if (scroll >= 100) {
                $("#nav").addClass("navbar-scroll");
            } else {
                $("#nav").removeClass("navbar-scroll");
            }
        });

        // Scroll to top of collapse on click.
        // Code borrowed from: https://stackoverflow.com/a/44303674/7316014
        $('.collapse').on('shown.bs.collapse', function (e) {
            var $card = $(this).closest('.card');
            $('html,body').animate({
                scrollTop: $card.offset().top - 50
            }, 500);
        });

        @if (Auth::check() && Auth::user()->member)
        initSlack('{{ route('api::slack::count') }}', '{{ route('api::slack::invite') }}');
        @endif

        initializeCountdowns();

    });
</script>

<script type="text/javascript">
    function initSlack(countRoute, inviteRoute) {

        $.ajax({
            'url': countRoute,
            'success': function (data) {
                $("#slack__online").html(data);
            },
            'error': function () {
                $("#slack__online").html('0');
            }
        });

        $("#slack__invite").on('click', function () {
            $("#slack__invite").html("Working...");
            $.ajax({
                'url': inviteRoute,
                'success': function (data) {
                    $("#slack__invite").html(data).attr("disabled", true);
                },
                'error': function () {
                    $("#slack__invite").html('Something went wrong...');
                }
            });
        });

    }
</script>

<!-- Matomo -->
<script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function () {
        var u = "//analytics.saproto.nl/";
        _paq.push(['setTrackerUrl', u + 'piwik.php']);
        _paq.push(['setSiteId', '1']);
        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
        g.type = 'text/javascript';
        g.async = true;
        g.defer = true;
        g.src = u + 'piwik.js';
        s.parentNode.insertBefore(g, s);
    })();
</script>
<!-- End Matomo Code -->

<!-- Search complete fields -->
<script type="text/javascript">

    $.fn.select2.defaults.set("theme", "bootstrap4");

    $(".user-search").select2({
        ajax: {
            url: "{{ route('api::search::user') }}",
            dataType: 'json',
            delay: 50,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: false
        },
        placeholder: 'Start typing a name...',
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 3,
        templateResult: function (item) {
            if (item.loading) {
                return item.text;
            } else if (item.is_member) {
                opacity = 1;
            } else {
                opacity = 0.3;
            }
            return "<span style='opacity: " + opacity + "'>" + item.name + " (#" + item.id + ")</span>";
        },
        templateSelection: function (item) {
            if (item.id == "") {
                return item.text;
            } else {
                return item.name + " (#" + item.id + ")";
            }
        }
    });

    $(".event-search").select2({
        ajax: {
            url: "{{ route('api::search::event') }}",
            dataType: 'json',
            delay: 50,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: false
        },
        placeholder: 'Start typing...',
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 3,
        templateResult: function (item) {
            if (item.loading) {
                return item.text;
            } else if (item.is_future) {
                opacity = 1;
            } else {
                opacity = 0.3;
            }
            return "<span style='opacity: " + opacity + "'>" + item.title + " (" + item.formatted_date.simple + ")</span>";
        },
        templateSelection: function (item) {
            if (item.id == "") {
                return item.text;
            } else {
                return item.title + " (" + item.formatted_date.simple + ")";
            }
        },
        sorter: function (data) {
            return data.sort(function (a, b) {
                if (a.start < b.start) {
                    return 1;
                } else if (a.start > b.start) {
                    return -1;
                } else {
                    return 0;
                }
            });
        }
    });

    $(".product-search").select2({
        ajax: {
            url: "{{ route('api::search::product') }}",
            dataType: 'json',
            delay: 50,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: false
        },
        placeholder: 'Start typing a name...',
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 3,
        templateResult: function (item) {
            if (item.loading) {
                return item.text;
            } else if (item.is_visible) {
                opacity = 1;
            } else {
                opacity = 0.3;
            }
            return "<span style='opacity: " + opacity + "'>" + item.name + " (€" + item.price.toFixed(2) + "; " + item.stock + " in stock)</div>";
        },
        templateSelection: function (item) {
            if (item.id == "") {
                return item.text;
            } else {
                return item.name;
            }
        },
        sorter: function (data) {
            return data.sort(function (a, b) {
                if (a.is_visible == 0 && b.is_visible == 1) {
                    return 1;
                } else if (a.is_visible == 1 && b.is_visible == 0) {
                    return -1;
                } else {
                    return 0;
                }
            });
        }
    });

    $(".committee-search").select2({
        ajax: {
            url: "{{ route('api::search::committee') }}",
            dataType: 'json',
            delay: 50,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: false
        },
        placeholder: 'Start typing a name...',
        minimumInputLength: 1,
        templateResult: function (item) {
            if (item.loading) {
                return item.text;
            }
            return item.name;
        },
        templateSelection: function (item) {
            if (item.id == "") {
                return item.text;
            } else {
                return item.name;
            }
        }
    });

</script>

<script type="text/javascript">

    function initializeCountdowns() {
        $(".proto-countdown").each(function (i, el) {
            setInterval(updateCountdown(el), 1000)
        });
    }

    function updateCountdown(e) {
        return function () {
            if (!$(e).hasClass('proto-countdown')) {
                return;
            }
            const start = new Date(e.getAttribute('data-countdown-start') * 1000);
            const countdown_text = e.getAttribute('data-countdown-text-counting');
            const finished_text = e.getAttribute('data-countdown-text-finished');
            const delta = Date.parse(start) - Date.parse(new Date());

            let text;
            if (delta < 0) {
                text = finished_text
            } else {
                const deltaText = updateCountdownGetTimestring(delta)
                text = countdown_text.replace("{}", deltaText)

            }
            $(e).html(text);
        }
    }

    function updateCountdownGetTimestring(delta) {
        const seconds = Math.floor((delta / 1000) % 60);
        const minutes = Math.floor((delta / 1000 / 60) % 60);
        const hours = Math.floor((delta / (1000 * 60 * 60)) % 24);
        const days = Math.floor(delta / (1000 * 60 * 60 * 24));

        let timestring;

        if (days > 1) {
            timestring = days + ' days';
        } else if (days == 1) {
            timestring = '1 day';
        } else if (hours > 0 || minutes > 0) {
            timestring = pad(hours, 2) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
        } else {
            timestring = seconds + ' seconds';
        }

        return timestring;

    }

</script>

<script type="text/javascript">
    function pad(n, width, z) {
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }
</script>