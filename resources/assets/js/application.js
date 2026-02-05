window.global ||= window

import * as Sentry from '@sentry/browser'
Sentry.init({
    dsn: config.sentry_dsn,
    integrations: [Sentry.browserTracingIntegration()],
    tracesSampleRate: parseFloat(config.sentry_sample_rate),
    sendDefaultPii: false,
    // Set `tracePropagationTargets` to control for which URLs trace propagation should be enabled
    tracePropagationTargets: ['localhost', /^https:\/\/proto\.utwente\.nl/],
})

import.meta.glob(['../images/**'])

// Vendors

import './utilities'
// Execute theme JavaScript
if (new Date().getMonth() + 1 !== 12) {
    if (config.theme == 'broto') {
        await import('./broto')
    }
    if (config.theme == 'night') {
        await import('./night')
    }

    window[config.theme]?.()
}

// Disable submit buttons after a form has been submitted so
// spamming the button does not result in multiple requests
let formList = Array.from(document.getElementsByTagName('form'))
formList.forEach((form) =>
    form.addEventListener('submit', preventSubmitBounce, { once: true })
)

if (document.querySelectorAll('.swiper').length) {
    const [{ default: Swiper }, { Autoplay, Navigation }] = await Promise.all([
        import('swiper'),
        import('swiper/modules'),
        import('swiper/css'),
        import('swiper/css/autoplay'),
        import('swiper/css/navigation'),
    ])
    window.swiper = new Swiper('.swiper', {
        modules: [Autoplay, Navigation],
        loop: config.company_count > 2,
        slidesPerView: config.company_count > 1 ? 2 : 1,
        spaceBetween: 10,
        watchOverflow: false,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            1200: {
                slidesPerView:
                    config.company_count > 4 ? 4 : config.company_count,
                spaceBetween: 50,
            },
        },
    })
}

// Enables tooltips elements
import { Tooltip } from 'bootstrap'

const tooltipTriggerList = Array.from(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
)
window.tooltips = {}
if (tooltipTriggerList.length) {
    tooltipTriggerList.forEach((el) => {
        window.tooltips[el.id] = Tooltip.getOrCreateInstance(el, {
            container: el.parentNode,
            boundary: document.body,
        })
    })
}

// Enable popover elements
import { Popover } from 'bootstrap'

const popoverTriggerList = Array.from(
    document.querySelectorAll('[data-bs-toggle="popover"]')
)
if (popoverTriggerList.length)
    popoverTriggerList.forEach((el) => new Popover(el))

// Enable modal elements
import { Modal } from 'bootstrap'

let modalList = Array.from(document.getElementsByClassName('modal'))
window.modals = {}
if (modalList.length) {
    modalList.forEach((el) => {
        window.modals[el.id] = Modal.getOrCreateInstance(el)
    })
}

// Enable custom file input elements
const customFileInputList = Array.from(
    document.getElementsByClassName('custom-file-input')
)
if (customFileInputList.length) {
    customFileInputList.forEach((el) => {
        el.addEventListener('change', () => {
            let fileName = this.value.split('\\').pop()
            let label = this.nextElementSibling
            label.classList.add('selected')
            label.innerHTML = fileName
        })
    })
}

const markdownFieldList = Array.from(
    document.getElementsByClassName('markdownfield')
)
if (markdownFieldList.length) {
    window.easyMDEFields = {}
    const [{ default: EasyMDE }] = await Promise.all([
        import('easymde'),
        import('easymde/dist/easymde.min.css'),
    ])
    markdownFieldList.forEach((el) => {
        window.easyMDEFields[el.id] = new EasyMDE({
            element: el,
            toolbar: [
                'bold',
                'italic',
                'strikethrough',
                '|',
                'table',
                'unordered-list',
                'ordered-list',
                '|',
                'image',
                'link',
                'quote',
                'code',
                '|',
                'preview',
                'guide',
            ],
            toolbarButtonClassPrefix: 'mde-',
            autoDownloadFontAwesome: false,
        })
    })
}

// Enables fancy scrolling effect
const navbar = document.getElementById('nav')
if (navbar) {
    const navbarHeight = 100
    let currentScroll = 0
    window.addEventListener('wheel', () => {
        currentScroll = document.documentElement.scrollTop
        if (currentScroll > navbarHeight) navbar.classList.add('navbar-scroll')
        else navbar.classList.remove('navbar-scroll')
    })
}

// Scroll to top of collapse on show.
// https://stackoverflow.com/a/44303674/7316014
// https://stackoverflow.com/a/18673641/14133333
const collapseList = Array.from(
    document.querySelectorAll('.collapse:not(#navbar)')
)
collapseList.map((el) => {
    el.addEventListener('shown.bs.collapse', (e) => {
        let card = e.target.closest('.card').getBoundingClientRect()
        window.scrollTo(0, card.top + window.scrollY - 60)
    })
})

const userSearchList = Array.from(document.querySelectorAll('.user-search'))
const eventSearchList = Array.from(document.querySelectorAll('.event-search'))
const productSearchList = Array.from(
    document.querySelectorAll('.product-search')
)
const achievementSearchList = Array.from(
    document.querySelectorAll('.achievement-search')
)
const committeeSearchList = Array.from(
    document.querySelectorAll('.committee-search')
)
if (
    userSearchList.length ||
    eventSearchList.length ||
    productSearchList.length ||
    achievementSearchList.length ||
    committeeSearchList.length
) {
    const [{ default: SearchField }] = await Promise.all([
        import('./search-field'),
    ])
    userSearchList.forEach(
        (el) =>
            new SearchField(el, config.routes.api_search_user, {
                optionTemplate: (el, item) => {
                    el.className = item.is_member ? '' : 'text-muted'
                    el.innerHTML = `#${item.id} ${item.name}`
                },
            })
    )

    eventSearchList.forEach(
        (el) =>
            new SearchField(el, config.routes.api_search_event, {
                optionTemplate: (el, item) => {
                    el.className = item.is_future ? '' : 'text-muted'
                    el.innerHTML = `${item.title} (${item.formatted_date.simple})`
                },
                selectedTemplate: (item) => item.title,
                sorter: (a, b) => {
                    if (a.start < b.start) return 1
                    else if (a.start > b.start) return -1
                    else return 0
                },
            })
    )

    productSearchList.forEach(
        (el) =>
            new SearchField(el, config.routes.api_search_product, {
                optionTemplate: (el, item) => {
                    el.className = item.is_visible ? '' : 'text-muted'
                    el.innerHTML = `${item.name} (€${item.price.toFixed(2)}; ${item.stock} in stock)`
                },
                selectedTemplate: (item) =>
                    item.name +
                    (el.multiple ? ` (€${item.price.toFixed(2)})` : ''),
                sorter: (a, b) => {
                    if (a.is_visible === 0 && b.is_visible === 1) return 1
                    else if (a.is_visible === 1 && b.is_visible === 0) return -1
                    else return 0
                },
            })
    )
    committeeSearchList.forEach(
        (el) => new SearchField(el, config.routes.api_search_committee)
    )
    achievementSearchList.forEach(
        (el) =>
            new SearchField(el, config.routes.api_search_achievement, {
                optionTemplate: (el, item) => {
                    el.innerHTML = `#${item.id} ${item.name}`
                },
            })
    )
}

// Enable countdown timers
global.timerList = []
const countdownList = Array.from(document.querySelectorAll('.proto-countdown'))
if (countdownList.length) {
    const [{ default: CountdownTimer }] = await Promise.all([
        import('./countdown-timer.js'),
    ])
    countdownList.forEach((el) => {
        timerList.push(new CountdownTimer(el))
    })
}

const shiftElements = document.querySelectorAll('.shift-select')
if (shiftElements.length) {
    const [{ default: shiftSelect }] = await Promise.all([
        import('./shift-select.js'),
    ])
    shiftElements.forEach((el) =>
        el.hasAttribute('data-name')
            ? shiftSelect(el, el.getAttribute('data-name'))
            : null
    )
}

//Lazy load background images
if ('IntersectionObserver' in window) {
    document.addEventListener('DOMContentLoaded', function () {
        function handleIntersection(entries) {
            entries.map((entry) => {
                if (entry.isIntersecting) {
                    entry.target.style.backgroundPosition = 'center'
                    entry.target.style.backgroundRepeat = 'no-repeat'
                    entry.target.style.backgroundSize = 'cover'
                    entry.target.style.backgroundImage =
                        "url('" + entry.target.dataset.bgimage + "')"
                    observer.unobserve(entry.target)
                }
            })
        }

        const headers = document.querySelectorAll(
            'div[data-bgimage]:not([data-bgimage=""])'
        )
        const observer = new IntersectionObserver(handleIntersection, {
            rootMargin: '200px',
        })
        headers.forEach((header) => observer.observe(header))
    })
} else {
    // No interaction support? Load all background images automatically
    const headers = document.querySelectorAll('.bg-img')
    headers.forEach((header) => {
        header.style.backgroundImage = "url('" + header.dataset.bgimage + "')"
    })
}

// Get online Discord users
const discordOnlineCount = document.getElementById('discord__online')
if (discordOnlineCount) {
    get(
        'https://discordapp.com/api/guilds/' +
            config.discord_server_id +
            '/widget.json'
    )
        .then((data) => {
            discordOnlineCount.innerHTML = data.presence_count
        })
        .catch(() => {
            discordOnlineCount.innerHTML = '...'
        })
}
