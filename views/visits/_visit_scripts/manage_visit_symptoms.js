$(function () {
    start();
});


let symptom = {
    "symptom_name": undefined,
    "description": undefined,
    "id": undefined
}

let data = {
    "symptoms": undefined,
    "symptom": undefined,
    "visit_symptom": undefined,
    "visit": undefined,
    "visit_symptoms": undefined
}


let VISIT_SYMPTOMS = undefined;
let VISIT = undefined;


function start() {

    // update visit symptoms table
    updateVisitSymptomsTable();


    // show the modal
    $("#btn_open_add_visit_symptoms").on("click", function () {
        $("#modal_add_visit_symptoms").modal("show");
    });

    // search symptoms
    let fieldSearchSymptoms = $("#field_search_symptoms");
    fieldSearchSymptoms.on("keyup", function () {

        let query = $(this).val();
        let resultsTable = $("#table_symptoms_results").DataTable();


        axios.get(`${getSiteUrl()}/api/symptoms/search?query=${query}`)
            .then(response => {
                return response.data
            })
            .then(data => {
                const symptoms = data.symptoms;

                resultsTable.rows().remove();

                for (const symptom of symptoms) {
                    resultsTable.row.add([
                        symptom.symptom_name,
                        `<button class="btn btn-success btn-sm btn_add_symptom_to_visit" data-symptom-id="${symptom.id}">+</button>`
                    ]);
                }

                resultsTable.draw();


                /**
                 * event listener for button add symptom to visit
                 */
                $(".btn_add_symptom_to_visit").on("click", function () {

                    const symptomId = $(this).attr("data-symptom-id");
                    processAddSymptomToVisit(symptomId);
                });


            })
            .catch(error => {
                showErrorToast(error);
            });


    });


}


function processAddSymptomToVisit(symptomId) {

    let visitId = $("#field_visit_id");

    axios.post(`${getSiteUrl()}/api/visit-symptom/adding`, {
        "visit_id": visitId.val(),
        "symptom_id": symptomId
    })
        .then(response => {
            return response.data;
        })
        .then(data => {

            showSuccessToast("Symptom added to visit");
            updateVisitSymptomsTable();


        })
        .catch(error => {
            showErrorToast(error.response.data.message);
        });


}


function updateVisitSymptomsTable() {

    let fieldVisitId = $("#field_visit_id");
    let tableVisitSymptoms = $("#table_visit_symptoms").DataTable();

    axios.get(`${getSiteUrl()}/api/visit-symptom/by-visit?id=${fieldVisitId.val()}`)
        .then(response => {
            return response.data;
        })
        .then(data => {

            console.log(data);

            VISIT = data.visit;
            VISIT_SYMPTOMS = data.visit_symptoms;


            tableVisitSymptoms.rows().remove();


            for (const visitSymptom of VISIT_SYMPTOMS) {
                tableVisitSymptoms.row.add([
                    visitSymptom.symptom.symptom_name,
                    `<button class="btn btn-sm btn-danger">-</button>`
                ]);
            }

            tableVisitSymptoms.draw();


        })
        .catch(error => {
            console.log(error);
        });

}