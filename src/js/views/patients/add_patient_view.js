import {makeInputFieldInvalid, resetInputFields} from "../../commom/forms/forms";
import {getSiteUrl, redirect, trimString} from "../../commom/helper";
import {showWarningToast} from "../../commom/toasts";
import {calculateAge} from "./patients_helper";

let axios = require('axios').default;


export function start() {

    if (document.getElementById("view_add_patient") == null) return false;

    addPatient();

}

function addPatient() {


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

    calculateAge(fields.dob, fields.age);

    $("#btn_add_patient").on("click", function () {

        resetInputFields($("#container_add_patient"))


        let validated = true;

        if (trimString(fields.first_name) === "") {
            validated = false;
            makeInputFieldInvalid(fields.first_name);
        }
        if (trimString(fields.last_name) === "") {
            validated = false;
            makeInputFieldInvalid(fields.last_name);
        }

        if (fields.gender.val() === "-") {
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
                const id = response.data.data.id;
                redirect(`${getSiteUrl()}/patients/edit?id=${id}`);

            })
            .catch(function (error) {
                showWarningToast(error.response.data.data);
            });


    });

}

