// window.Vue = require("vue");

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

    $(".datatable").dataTable({
        "pageLength": 50,
        "columnDefs": [],
        "ordering": true
    });

    $(".datatable_simple").DataTable({
        "paging": false,
    });

    $(".datatable_basic").DataTable({
        "paging": false,
        "searching": false
    });


    // loginViews.start();
    // usersViews.all();
    // patientsViews.all();
    // visitsViews.all();
    // symptomsViews.all();

});


// import Welcome from "./components/home/Welcome";
//
// const app = new Vue({
//     el: "#app",
//     components: {
//         Welcome
//     }
// });