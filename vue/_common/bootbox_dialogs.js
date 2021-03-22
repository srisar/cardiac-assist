export function successMessageBox(message) {
    bootbox.alert({
        title: '<span class="text-success"><i class="bi bi-info-circle-fill"></i> SUCCESS</span>',
        message: `<div class="text-center">${message}</div>`
    })
}


export function errorMessageBox(message) {
    bootbox.alert({
        title: '<span class="text-danger"><i class="bi bi-exclamation-circle-fill"></i> ERROR</span>',
        message: message
    })
}
