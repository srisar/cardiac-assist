function getSiteURL() {
    return `${window.location.protocol}//${window.location.hostname}`
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
