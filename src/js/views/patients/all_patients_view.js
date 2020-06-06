import {getSiteUrl, toCurrency} from "../../commom/helper";
import {showErrorToast} from "../../commom/toasts";

let axios = require('axios').default;

export function start() {
    if (document.getElementById("view_all_patient") == null) return false;

    populatePatients();

}

function populatePatients() {

    let dataTable = $("#table_all_patients").DataTable();

    axios.get(`${getSiteUrl()}/api/patients/all`, {
        limit: 50,
        offset: 0
    })
        .then(function (response) {

            let patients = response.data.data;

            for (const patient of patients){
                dataTable.row.add([
                    `<a href="${getSiteUrl()}/patients/edit?id=${patient['id']}">${patient['first_name']} ${patient['last_name']}</a>`,
                    patient['gender'],
                    patient['dob'],
                    patient['age'],
                    patient['address'],
                    patient['phone'],
                    patient['job'],
                    patient['job_type'],
                    toCurrency(patient['income'])
                ]);
            }

            dataTable.draw();

        })
        .catch(function (error) {
            showErrorToast(error.response.data.data);
        });

}