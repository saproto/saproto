// Vendors
global.$ = global.jQuery = require('jquery');
global.Quagga = require('quagga');
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

/*disable all buttons on a page after a form has been submitted so spamming the button doesnt result in two or more entries*/
window.addEventListener('load', (event) => {
    let forms = document.querySelectorAll("form")
    let formEventListener = event => {
        event.preventDefault()
        event.target.removeEventListener('submit', formEventListener);
        event.target.onsubmit = _ => false;
        event.target.submit()
    }
    forms.forEach((form) => {
        form.addEventListener('submit', formEventListener)
    })
});

// Update locale
moment.updateLocale('en', {
    week: {dow: 1}
});

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

//April fools
//tIpCiE
function createTipcieString() {
    return 'tipcie'.split('').map(c => {
        return Math.random() < .5? c : c.toUpperCase();
    }).join('');
}

window.addEventListener("DOMContentLoaded", function(){
    let els = document.querySelectorAll("*");
    els.forEach((el) => {
        el.childNodes.forEach((child) => {
            if (child.nodeType === 3) {
                child.nodeValue = child.nodeValue.replace(
                    /tipcie/gi,
                    createTipcieString()
                );
            }
        });
    });
    document.getElementById('april-glasses').addEventListener('click', _ => {
        document.getElementsByTagName('nav')[0].style.filter = 'blur(0)';
        document.getElementsByTagName('main')[0].style.filter = 'blur(0)';
        document.getElementsByTagName('footer')[0].style.filter = 'blur(0)';
    })
});