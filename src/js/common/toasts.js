toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-bottom-left",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

function showInfoToast(message) {
    toastr.info(message);
}

function showWarningToast(message) {
    toastr.warning(message);
}

function showErrorToast(message) {
    toastr.error(message);
}

function showSuccessToast(message) {
    toastr.success(message);
}