$(function () {
    processLoadAddSymptoms();
    processAddNewSymptom();
});


function processLoadAddSymptoms() {

    axios.get(`${getSiteUrl()}/api/symptom/all`)
        .then(response => {
            return response.data;
        })
        .then(data => {

            const symptoms = data.symptoms;
            populateSymptomsTable(symptoms);

        })
        .catch(error => {

            const responseError = error.response.data.message;

            if (responseError !== undefined) {
                showErrorToast(responseError);
            } else {
                showErrorToast("Unable to load existing symptoms.");
            }

        });


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

    }


}


function processAddNewSymptom() {

    let fields = {
        "symptom_name": $("#field_symptom_name"),
        "description": $("#field_symptom_description"),
    };


    $("#btn_add_symptom").on("click", function () {

        let validated = true;

        if (trimString(fields.symptom_name) === "") {
            validated = false;
            makeInputFieldInvalid(fields.symptom_name);
        }


        if (!validated) return false;


        axios.post(`${getSiteUrl()}/api/symptom/add`, {
            "symptom_name": trimString(fields.symptom_name),
            "description": trimString(fields.description)
        })
            .then(response => {
                return response.data;
            })
            .then(data => {
                processLoadAddSymptoms();
            })
            .catch(error => {

                const responseError = error.response.data.message;

                if (responseError !== undefined) {
                    showErrorToast(responseError);
                } else {
                    showErrorToast("Unable to add a new symptom");
                }
            });
    });


}