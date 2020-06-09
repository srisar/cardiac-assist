$(function () {
    addVisit();
});


function addVisit() {

    let fields = {
        "patient_id": $("#field_patient_id"),
        "visit_date": $("#field_visit_date"),
        "remarks": $("#field_remarks"),
    };


    $("#btn_add_visit").on("click", function () {

        axios.post(`${getSiteUrl()}/api/visits/adding`, {
            "patient_id": parseInt(fields.patient_id.val()),
            "visit_date": fields.visit_date.val(),
            "remarks": trimString(fields.remarks)
        })
            .then(response => {
                return response.data;
            })
            .then(data => {

                console.log(data);

                const id = data.patient.id;
                redirect(`${getSiteUrl()}/visits/edit?id=${id}`);

            })
            .catch(error => {
                showErrorToast(error.response.data.message);
            });

    });

}