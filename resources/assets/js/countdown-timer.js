function updateCountdown(el) {
    return function () {
        if (!el.classList.contains('proto-countdown')) return
        const start = new Date(el.getAttribute('data-countdown-start') * 1000)
        const countdown_text = el.getAttribute('data-countdown-text-counting')
        const finished_text = el.getAttribute('data-countdown-text-finished')
        const delta = start.getTime() - (new Date()).getTime()
        const deltaText = updateCountdownGetTimeString(delta)
        el.innerHTML = delta < 0 ? finished_text : countdown_text.replace("{}", deltaText)
    }
}

function updateCountdownGetTimeString(delta) {
    const seconds = Math.floor((delta / 1000) % 60);
    const minutes = Math.floor((delta / 1000 / 60) % 60);
    const hours = Math.floor((delta / (1000 * 60 * 60)) % 24);
    const days = Math.floor(delta / (1000 * 60 * 60 * 24));

    let timestring;

    if (days > 1)
        timestring = days + ' days';
    else if (days === 1)
        timestring = '1 day';
    else if (hours > 0 || minutes > 0)
        timestring = pad(hours, 2) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
    else
        timestring = seconds + ' seconds';

    return timestring;

}

function pad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

window.initializeCountdowns = function() {
    const countdownList = Array.from(document.querySelectorAll(".proto-countdown"))
    countdownList.forEach(el => { setInterval(updateCountdown(el), 1000) })
}

initializeCountdowns()