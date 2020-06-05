import * as helper from "../../commom/helper";
import * as toast from "../../commom/toasts";
import {makeInputFieldInvalid, resetInputFields} from "../../commom/forms/forms";
import {getSiteUrl, trimString} from "../../commom/helper";
import {showInfoToast, showWarningToast} from "../../commom/toasts";

let axios = require('axios').default;


export function start() {

    if (document.getElementById("view_add_patient") == null) return false;

    addUser();

}

function addUser() {

    $("#btn_add_patient").on("click", function () {

        resetInputFields($("#container_add_patient"))

        let fields = {
            'first_name': $("#field_first_name"),
            'last_name': $("#field_last_name"),
            'gender': $("#field_sex"),
            'nic': $("#field_nic"),
            'dob': $("#field_dob"),
            'age': $("#field_age"),
            'phone': $("#field_phone"),
            'address': $("#field_address"),
            'ds_division': $("#field_ds_division"),
            'job': $("#field_job"),
            'job_type': $("#field_job_type"),
            'income': $("#field_income"),
        };


        let validated: boolean = true;

        if (trimString(fields.first_name) === "") {
            validated = false;
            makeInputFieldInvalid(fields.first_name);
        }
        if (trimString(fields.last_name) === "") {
            validated = false;
            makeInputFieldInvalid(fields.last_name);
        }

        if (fields.gender.val().toString() === "-1") {
            validated = false;
            makeInputFieldInvalid(fields.gender);
        }


        if (!validated) return false;

        axios.post(`${getSiteUrl()}/api/patients/adding`, {
            'first_name': trimString(fields.first_name),
            'last_name': trimString(fields.last_name),
            'gender': trimString(fields.gender),
            'nic': trimString(fields.nic),
            'dob': trimString(fields.dob),
            'age': trimString(fields.age),
            'phone': trimString(fields.phone),
            'address': trimString(fields.address),
            'ds_division': trimString(fields.ds_division),
            'job': trimString(fields.job),
            'job_type': trimString(fields.job_type),
            'income': trimString(fields.income),
        })
            .then(function (response) {

                console.log(response.data.data);

            })
            .catch(function (error) {
                showWarningToast(error.response.data.data);
            });


    });

}