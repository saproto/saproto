<script type="text/javascript" src="{{ asset('assets/application.min.js') }}"></script>

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

        initSlack('{{ route('api::slack::count') }}', '{{ route('api::slack::invite') }}');

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

<script>

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-36196842-2', 'auto');
    ga('send', 'pageview');

</script>
