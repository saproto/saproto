// Vendors
window.moment = require('moment')
window.SignaturePad = require('signature_pad')
window.io = require('socket.io-client')
window.Cookies = require('js-cookie')
window.axios = require('axios')
require('./countdown-timer')
require('./search-complete')

import EasyMDE from "easymde";
import Iconpicker from "codethereal-iconpicker"
import { Modal, Tooltip, Popover } from 'bootstrap'

// Register CSRF token
let token = document.head.querySelector('meta[name="csrf-token"]')
if (token) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
else console.error('CSRF token not found')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Update locale
moment.updateLocale('en', { week: {dow: 1} })

// Initialise Swiper on home page
import Swiper, { Autoplay, Navigation} from 'swiper'
if(document.getElementsByClassName('.swiper').length) {
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

// Execute theme JavaScript
window[config.theme]?.()

// Enables tooltips elements
const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
const tooltipList = tooltipTriggerList.map((el) => new Tooltip(el, {boundary: 'window'}))

// Enable popover elements
const popoverTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="popover"]'))
const popoverList = popoverTriggerList.map((el) => new Popover(el))

// Enable custom file input elements
const customFileInputList = Array.from(document.getElementsByClassName('custom-file-input'))
customFileInputList.forEach((el) => {
    el.addEventListener('change', () => {
        let fileName = this.value.split('\\').pop()
        let label = this.nextElementSibling
        label.classList.add( 'selected')
        label.innerHTML = fileName
    })
})

let modalList = Array.from(document.getElementsByClassName('modal'))
window.modals = {}
modalList.forEach(el => {
    window.modals[el.id] = Modal.getOrCreateInstance(el)
})

// Enable EasyMDE markdown fields
const markdownFieldList = Array.from(document.getElementsByClassName('markdownfield'))
window.easyMDEFields = {}
markdownFieldList.forEach(el => {
    window.easyMDEFields[el.id] =
        new EasyMDE({
            element: el,
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "image", "link", "quote", "table", "code", "|", "preview"],
            autoDownloadFontAwesome: false
        })
})
const statusbarList = Array.from(document.querySelectorAll('.editor-statusbar'))
const link = "<a class='md-ref float-start' target='_blank' href='https://www.markdownguide.org/basic-syntax/'>markdown syntax</a>"
statusbarList.forEach(el => el.innerHTML = link + el.innerHTML)

const iconPickerList = Array.from(document.getElementsByClassName('iconpicker-wrapper'))
window.iconPickers = {}
iconPickerList.forEach(el => {
    const iconpicker = el.querySelector('.iconpicker')
    window.iconPickers[el.id] = new Iconpicker(iconpicker, {
        icons: require('./fontawesome-icons.json'), // Make sure this list is up to date!
        defaultValue: iconpicker.value,
        showSelectedIn: el.querySelector('.selected-icon'),
    })
})


// Enables the fancy scrolling effect
const navbar = document.getElementById('nav')
if (navbar) {
    const navbarHeight = 100;
    let currentScroll = 0;
    window.addEventListener('wheel', (e) => {
        currentScroll = document.documentElement.scrollTop
        if (currentScroll > navbarHeight) navbar.classList.add('navbar-scroll')
        else navbar.classList.remove('navbar-scroll')
    })
}

// Scroll to top of collapse on show.
// https://stackoverflow.com/a/44303674/7316014
// https://stackoverflow.com/a/18673641/14133333
const collapseList = Array.from(document.querySelectorAll('.collapse:not(#navbar)'))
collapseList.map((el) => {
    el.addEventListener('shown.bs.collapse', (e) => {
        let card = e.target.closest('.card').getBoundingClientRect()
        window.scrollTo(0, card.top + window.scrollY - 60)
    })
})

// Matomo Analytics
const _paq = _paq || [];
// tracker methods like "setCustomDimension" should be called before "trackPageView"
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
(() => {
    let u = "//"+config.analytics_url+"/";
    _paq.push(['setTrackerUrl', u + 'piwik.php']);
    _paq.push(['setSiteId', '1']);
    let d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
    g.type = 'text/javascript';
    g.async = true;
    g.defer = true;
    g.src = u + 'piwik.js';
    s.parentNode.insertBefore(g, s);
})()