/**
 * Bootstrap
 */
$(function () {

    const visitId = $("#field_visit_id");

    let manageVisitSymptoms = new ManageVisitSymptoms(visitId.val());
    manageVisitSymptoms.listen();

});


/*
 |
 | Classes
 |
 */

class ManageVisitSymptoms {


    constructor(visitId) {
        this.visitId = visitId;

        this.visitSymptoms = undefined;
        this.visit = undefined;

        this.TABLE_VISIT_SYMPTOMS = $("#table_visit_symptoms").DataTable();
        this.TABLE_SEARCH_RESULTS = $("#table_symptoms_results").DataTable();


    }

    /**
     * Fetch the visit-symptoms data from server, this is the staring point for
     * all other processes, such as updating the table and search and remove.
     * @returns {Promise<void>}
     */
    async fetch() {

        await axios.get(`${getSiteUrl()}/api/visit-symptom/by-visit?id=${this.visitId}`)
            .then(response => {
                return response.data;
            })
            .then(data => {

                this.visit = data.visit;
                this.visitSymptoms = data.visit_symptoms;

            })
            .catch(error => {
                console.log(error);
            });

    }

    listen() {

        this.fetch().then(() => {
            this._updateVisitSymptomsTable();
            this._doSearchForSymptoms();

        });

    }


    _checkSymptomExist(symptom) {

        let result = _.find(this.visitSymptoms, function (o) {
            return o.symptom_id === symptom.id;
        });

        return result !== undefined;
    }

    _updateVisitSymptomsTable() {

        let self = this;

        this.TABLE_VISIT_SYMPTOMS.rows().remove();


        for (const visitSymptom of this.visitSymptoms) {
            this.TABLE_VISIT_SYMPTOMS.row.add([
                visitSymptom.symptom.symptom_name,
                `<button class="btn btn-sm btn-danger btn_remove_visit_symptom text-center" data-visit-symptom-id="${visitSymptom.id}">Remove</button>`
            ]);
        }

        this.TABLE_VISIT_SYMPTOMS.draw();

        /**
         * Event listener for removing symptom from visit.
         */
        $(".btn_remove_visit_symptom").on("click", function () {
            const visitSymptomId = $(this).attr("data-visit-symptom-id");
            self._processDeleteSymptomFromVisit(visitSymptomId);
        });


    }

    /**
     *  Open search for symptoms modal and add symptoms from search table
     * @private
     */
    _doSearchForSymptoms() {

        // show the modal
        $("#btn_open_add_visit_symptoms").on("click", function () {
            $("#modal_add_visit_symptoms").modal("show");
        });

        let fieldSearchSymptoms = $("#field_search_symptoms");

        const self = this;

        /**
         *
         */
        fieldSearchSymptoms.on("keyup", function () {

            let query = $(this).val();
            let notFoundContainer = $("#area_show_add_symptom_to_db");


            axios.get(`${getSiteUrl()}/api/symptom/search?query=${query}`)
                .then(response => {
                    return response.data
                })
                .then(data => {


                    const results = data.symptoms;


                    if (_.isEmpty(results)) {

                        self._updateSearchResultsTable(results);

                        notFoundContainer.html(`No results found for ${query}. Do you want to <a href="#" id="link_add_new_symptom">add</a> it to database?`);

                        $("#link_add_new_symptom").on("click", function () {
                            self._processAddNewSymptom(query);

                        });


                    } else {

                        notFoundContainer.empty();

                        self._updateSearchResultsTable(results);


                        /**
                         * event listener for button add symptom to visit
                         */
                        $(".btn_add_visit_symptom").on("click", function () {

                            const symptomId = $(this).attr("data-symptom-id");
                            self._processAddSymptomToVisit(symptomId);
                        });


                    }


                })
                .catch(error => {
                    console.log(error);
                    showErrorToast(error);
                });


        });
    }

    _updateSearchResultsTable(results) {

        this.TABLE_SEARCH_RESULTS.rows().remove();

        for (const symptom of results) {

            let disabled = this._checkSymptomExist(symptom) ? "disabled" : "";

            this.TABLE_SEARCH_RESULTS.row.add([
                symptom.symptom_name,
                `<button class="btn btn-success btn-sm btn_add_visit_symptom ${disabled} text-center" data-symptom-id="${symptom.id}">Add</button>`
            ]);
        }


        this.TABLE_SEARCH_RESULTS.draw();
    }


    /**
     *
     * @param symptomId
     * @private
     */
    async _processAddSymptomToVisit(symptomId) {

        let self = this;

        axios.post(`${getSiteUrl()}/api/visit-symptom/add`, {
            "visit_id": this.visitId,
            "symptom_id": symptomId
        })
            .then(response => {
                return response.data;
            })
            .then(data => {

                showSuccessToast("Symptom added to visit");

                this.fetch().then(() => {
                    this._updateVisitSymptomsTable(self.visitSymptoms);
                });

            })
            .catch(error => {
                showErrorToast(error.response.data.message);
            });
    }

    /**
     *
     * @param visitSymptomId
     * @private
     */
    _processDeleteSymptomFromVisit(visitSymptomId) {

        axios.post(`${getSiteUrl()}/api/visit-symptom/delete`, {
            "id": visitSymptomId
        })
            .then(response => {
                return response.data;
            })
            .then(data => {

                showSuccessToast(data.message);

                this.fetch().then(() => {
                    this._updateVisitSymptomsTable(this.visitSymptoms);
                });


            })
            .catch(function (error) {
                console.log(error);
                showErrorToast(error.response.data.message);
            });
    }


    _processAddNewSymptom(symptomName) {

        axios.post(`${getSiteUrl()}/api/symptom/add`, {
            "symptom_name": symptomName,
            "description": ""
        })
            .then(response => {
                return response.data
            })
            .then(data => {
                
                // adding the newly added symptom to visit as well
                this._processAddSymptomToVisit(data.symptom.id).then(() => {
                    // update the table
                    this._updateVisitSymptomsTable();
                });


            })
            .catch(error => {

                const responseError = error.response.data.message;

                if (responseError !== undefined) {
                    showErrorToast(responseError);
                } else {
                    showErrorToast("Unable to add a new symptom");
                }

            });

    }

}
