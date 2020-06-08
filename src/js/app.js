/**
 * Application bootstrap
 */
$(function () {

    validateFormFields();

    $(".date_field").daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "autoApply": true,
        "locale": {
            "format": "YYYY-MM-DD"
        }
    });

    $(".datatable").DataTable({
        "pageLength": 50,
        "columnDefs": [],
        "ordering": true
    });

    $(".datatable_simple").DataTable({
        "paging": false,
    })


    // loginViews.start();
    // usersViews.all();
    // patientsViews.all();
    // visitsViews.all();
    // symptomsViews.all();

})