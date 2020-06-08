import {getSiteUrl, trimString} from "../../commom/helper";
import {showErrorToast, showSuccessToast} from "../../commom/toasts";

let axios = require("axios").default;

export function start() {
    if (document.getElementById("view_edit_visit") == null) return false;

    updateVisitDetails();

}

function updateVisitDetails() {

    let fields = {
        "id": $("#field_id"),
        "visit_date": $("#field_visit_date"),
        "remarks": $("#field_remarks"),
    };


    $("#btn_update_visit").on("click", function () {

        axios.post(`${getSiteUrl()}/api/visits/updating`, {
            "id": fields.id.val(),
            "visit_date": fields.visit_date.val(),
            "remarks": trimString(fields.remarks)
        })
            .then(response => {
                return response.data
            })
            .then(data => {

                showSuccessToast(data.message);

            })
            .catch(error => {
                showErrorToast(error.response.data.message);
            });

    });

}

