function initializeCountdowns() {
    $(".proto-countdown").each(function (i, el) {
        setInterval(updateCountdown(el), 1000)
    });
}

function updateCountdown(e) {
    return function () {
        if (!$(e).hasClass('proto-countdown')) return;
        const start = new Date(e.getAttribute('data-countdown-start') * 1000);
        const countdown_text = e.getAttribute('data-countdown-text-counting');
        const finished_text = e.getAttribute('data-countdown-text-finished');
        const delta = start.getTime() - (new Date()).getTime();

        let text;
        if (delta < 0) {
            text = finished_text
        } else {
            const deltaText = updateCountdownGetTimeString(delta)
            text = countdown_text.replace("{}", deltaText)
        }

        $(e).html(text);
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

initializeCountdowns()