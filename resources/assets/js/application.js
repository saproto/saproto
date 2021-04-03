// Vendors
global.$ = global.jQuery = require('jquery');
window.popper = require('popper.js')
window.moment = require('moment')
window.SignaturePad = require('signature_pad')
window.Swiper = require('swiper')
window.EasyMDE = require('easymde')
window.io = require('socket.io-client')
window.Cookies = require('js-cookie')
require('bootstrap')
require('tempusdominus-bootstrap-4')
require('bootstrap-slider')
require('select2')
require('fontawesome-iconpicker')


// Update locale
moment.updateLocale('en', {
    week: {dow: 1}
});

// On document loaded
$(function() {
    // Enables tooltips
    $('[data-toggle="tooltip"]').tooltip()

    // Enable popover
    $('[data-toggle="popover"]').popover()

    $(".custom-file-input").on("change", function() {
        let fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    })

    // Enables the fancy scrolling effect
    $(window).on("scroll",function () {
        let scroll = $(window).scrollTop();
        if (scroll >= 100) $("#nav").addClass("navbar-scroll");
        else $("#nav").removeClass("navbar-scroll");
    })

    // Scroll to top of collapse on click.
    // Code borrowed from: https://stackoverflow.com/a/44303674/7316014
    $('.collapse').not('#navbar').on('shown.bs.collapse', function (e) {
        let card = $(this).closest('.card');
        $('html,body').animate({
            scrollTop: card.offset().top - 50
        }, 500);
    })

    // Matomo Analytics
    const _paq = _paq || [];
    // tracker methods like "setCustomDimension" should be called before "trackPageView"
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function () {
        let u = "//{{ config('proto.analytics_url') }}/";
        _paq.push(['setTrackerUrl', u + 'piwik.php']);
        _paq.push(['setSiteId', '1']);
        let d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
        g.type = 'text/javascript';
        g.async = true;
        g.defer = true;
        g.src = u + 'piwik.js';
        s.parentNode.insertBefore(g, s);
    })();

    // Set Select2 theme
    $.fn.select2.defaults.set("theme", "bootstrap4");
})