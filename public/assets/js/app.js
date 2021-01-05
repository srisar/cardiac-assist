function getSiteURL() {
    return `${window.location.protocol}//${window.location.hostname}`
}

function redirect(path) {
    location.replace(path);
}

function reload() {
    location.reload();
}

function isEmptyField(field) {
    if (field.val().trim() === "") {
        field.removeClass("is-valid");
        field.addClass("is-invalid");
        return true;
    } else {
        field.removeClass("is-invalid");
        field.addClass("is-valid");
        return false;
    }
}

function getStringValue(field) {
    return field.val().trim();
}

function getIntegerValue(field) {
    return parseInt(field.val().trim());
}

function getFloatValue(field) {
    return parseFloat(field.val().trim());
}