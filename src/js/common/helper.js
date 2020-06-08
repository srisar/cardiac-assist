/**
 * Reloads the page
 */
function reloadPage() {
    window.location.reload();
}


/**
 * Gets the base site url with protocol
 * Eg. http://localhost/
 * @returns {string}
 */
function getSiteUrl() {
    return `${window.location.protocol}//${window.location.hostname}`;

}

/**
 * Redirects to the given url path
 * @param path
 */
function redirect(path) {
    location.replace(path);
}


function trimString(field) {
    return field.val().toString().trim();
}


function toCurrency(value) {
    return `Rs. ${parseFloat(value).toFixed(2)}`;
}