import {validateFormFields} from "./commom/forms/forms";
import * as loginViews from "./views/system/auth/login_view";
import * as usersViews from "./views/system/users/users_all"
import * as patientsViews from "./views/patients/patients_all";
import * as visitsViews from "./views/visits/visits_all";
import * as symptomsViews from "./views/symptoms/symptoms";


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


    loginViews.start();
    usersViews.all();
    patientsViews.all();
    visitsViews.all();
    symptomsViews.all();

})