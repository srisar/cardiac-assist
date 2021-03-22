export function successMessageBox(message) {
    bootbox.alert({
        title: '<i class="bi bi-info-circle"></i> Success',
        message: message
    })
}


export function errorMessageBox(message) {
    bootbox.alert({
        title: '<i class="bi bi-exclamation-circle-fill"></i> Error',
        message: message
    })
}
