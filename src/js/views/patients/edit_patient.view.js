import {calculateAge} from "./patients_helper";
import {getSiteUrl, trimString} from "../../commom/helper";
import {showErrorToast, showSuccessToast} from "../../commom/toasts";

let axios = require("axios").default;

export function start() {
    if (document.getElementById("view_edit_patient") == null) return false;

    updatePatient();

}

function updatePatient() {

    let fields = {
        "id": $("#field_id"),
        "first_name": $("#field_first_name"),
        "last_name": $("#field_last_name"),
        "gender": $("#field_sex"),
        "nic": $("#field_nic"),
        "dob": $("#field_dob"),
        "age": $("#field_age"),
        "phone": $("#field_phone"),
        "address": $("#field_address"),
        "ds_division": $("#field_ds_division"),
        "job": $("#field_job"),
        "job_type": $("#field_job_type"),
        "income": $("#field_income"),
        "status": $("#field_status")
    };

    calculateAge(fields.dob, fields.age);

    $("#btn_update_patient").on("click", function () {

        axios.post(`${getSiteUrl()}/api/patients/editing`, {
            "id": parseInt(fields.id.val()),
            "first_name": trimString(fields.first_name),
            "last_name": trimString(fields.last_name),
            "gender": trimString(fields.gender),
            "nic": trimString(fields.nic),
            "dob": trimString(fields.dob),
            "age": parseInt(fields.age.val()),
            "phone": trimString(fields.phone),
            "address": trimString(fields.address),
            "ds_division": trimString(fields.ds_division),
            "job": trimString(fields.job),
            "job_type": trimString(fields.job_type),
            "income": trimString(fields.income),
            "status": trimString(fields.status),
        })
            .then(response => {
                return response.data
            })
            .then(data => {
                showSuccessToast(data.data);
                console.log(data.data);
            })
            .catch(error => {
                showErrorToast(error.response.data.data);
                console.log(error.response.data.data);
            });

    });

}
