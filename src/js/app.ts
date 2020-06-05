import {validateFormFields} from "./commom/forms/forms";
import * as loginView from "./views/system/auth/login.view";
import * as userView from "./views/system/users/users.all"
import * as patientView from "./views/patients/patients.all";

/**
 * Application bootstrap
 */
$(function () {


    validateFormFields();

    loginView.start();
    userView.all();
    patientView.all();

    $(".date_field").daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "locale": {
            "format": "YYYY-MM-DD"
        }
    });


});

