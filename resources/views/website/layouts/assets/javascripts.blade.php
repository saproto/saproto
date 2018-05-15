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

        @if (Auth::check() && Auth::user()->member && Cookie::get('hideSlack', 'show') === 'show')
        initSlack('{{ route('api::slack::count') }}', '{{ route('api::slack::invite') }}');
        @endif


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

        $("#slack__hide").on('click', function () {
            if (confirm("This will hide the Slack status button from your navigation bar. The only way to undo this action is to clear your browser cookies. Are you sure?")) {
                document.cookie = "hideSlack=yesSir; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
                window.location.reload();
            }
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
        var u = "//metis.proto.utwente.nl/analytics/";
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