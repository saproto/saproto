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
                $("#navbar").addClass("navbar-scroll");
            } else {
                $("#navbar").removeClass("navbar-scroll");
            }
        });

    });
</script>
