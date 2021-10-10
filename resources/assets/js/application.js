// Vendors
global.$ = global.jQuery = require('jquery');
window.popper = require('popper.js')
window.moment = require('moment')
window.SignaturePad = require('signature_pad')
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

// Initialise Swiper on home page
import Swiper, { Autoplay, Navigation} from 'swiper'
if($('.swiper').length) {
    Swiper.use([Autoplay, Navigation]);
    window.swiper = new Swiper('.swiper', {
        loop: config.company_count > 2,
        slidesPerView: config.company_count > 1 ? 2 : 1,
        spaceBetween: 10,
        watchOverflow: false,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        },
        breakpoints: {
            1200: {
                slidesPerView: (config.company_count > 4 ? 4 : config.company_count),
                spaceBetween: 50,
            }
        }
    })
}

// On document loaded
$(function() {
    // Execute theme JavaScript
    window[config.theme]?.()

    // Enables tooltips
    $('[data-toggle="tooltip"]').tooltip({ boundary: 'window'})

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
        let u = "//"+config.analytics_url+"/";
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