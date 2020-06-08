
function loadAllSymptoms() {

    axios.get(`${getSiteUrl()}/api/symptoms/all`)
        .then(response => {
            return response.data;
        })
        .then(data => {

            const symptoms = data.symptoms;
            populateSymptomsTable(symptoms);

        })
        .catch(error => {
            showWarningToast("Unable to load existing symptoms.");
        });

}

function populateSymptomsTable(symptoms) {

    let table = $("#table_symptoms").DataTable();

    table.rows().remove().draw();

    for (const symptom of symptoms) {
        table.row.add([
            `<a class="btn_symptom" data-id="${symptom.id}" href="#">${symptom.symptom_name}</a>`,
            `${symptom.description.substring(0, 100)}...`
        ]);
    }

    table.draw();

    //editSymptom();

}


$(function () {
    loadAllSymptoms();
});