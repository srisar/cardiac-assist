function getSiteURL() {

    let port = window.location.port

    return `${window.location.protocol}//${window.location.hostname}:${port}`
}

function redirect(path) {
    location.replace(path);
}

function reload() {
    location.reload();
}

function toCurrency(value, currency = 'LKR', lang = 'en-LK') {
    return new Intl.NumberFormat(lang, {style: 'currency', currency: currency}).format(value);
}

function toBrString(text) {
    return text.replace(/(?:\r\n|\r|\n)/g, '<br>');
}
