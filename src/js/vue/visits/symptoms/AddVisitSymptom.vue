<template>
    <div>

        <div class="modal fade" id="modal_add_visit_symptoms" tabindex="-1" role="dialog" aria-labelledby="modal_add_visit_symptoms" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Add symptoms to visit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="text" placeholder="Type for symptoms"
                                   id="field_search_symptoms"
                                   class="form-control"
                                   autocomplete="off"
                                   v-model.trim="query"
                                   @keyup="search">
                        </div>

                        <div class="mb-2"
                             v-if="isResultsEmpty && !isEmptyQuery">
                            No results found for {{query}}. Do you want to <a href="#" @click="addNewSymptom">add as new</a>?
                        </div>

                        <table class="table table-bordered" v-if="!isResultsEmpty">
                            <thead>
                            <tr>
                                <th>Symptom</th>
                                <th style="width: 30px">Add</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="symptom in results">
                                <td>{{symptom.symptom_name}}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" @click="addSymptomToVisit(symptom)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>

                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        name: "AddVisitSymptom",
        props: ["eventBus", "visitId"],

        data() {
            return {
                query: "",
                selectedSymptom: null,
                results: {},
            }
        },

        computed: {
            isResultsEmpty: function () {
                return _.isEmpty(this.results);
            },

            isEmptyQuery: function () {
                return _.isEmpty(this.query);
            }

        },

        methods: {

            /**
             * do the search for keyup on search field
             */
            search: _.debounce(function () {
                this.fetchResults();
            }, 300),


            /**
             * fetch the results from server
             */
            fetchResults: function () {

                axios
                    .get(`${getSiteUrl()}/api/symptom/search?query=${this.query}`)
                    .then(res => {

                        this.results = res.data.symptoms;

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    })
            },

            /**
             * add a selected symptom to visit
             */
            addSymptomToVisit: function (symptom) {
                this.selectedSymptom = symptom;

                axios
                    .post(`${getSiteUrl()}/api/visit-symptom/add`, {
                        symptom_id: this.selectedSymptom.id,
                        visit_id: this.visitId
                    })
                    .then(res => {

                        showSuccessToast(`${this.selectedSymptom.symptom_name} is added.`);
                        this.emitUpdateVisitSymptomsTable();

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    })

            },

            /**
             * add a new symptom into database if it doesnt exist already
             */
            addNewSymptom: function () {

                axios
                    .post(`${getSiteUrl()}/api/symptom/add`, {
                        symptom_name: this.query,
                        description: ""
                    })
                    .then(res => {

                        this.fetchResults();

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    })

            },

            /**
             * emit update-visit-symptom table
             */
            emitUpdateVisitSymptomsTable: function () {
                this.eventBus.$emit('update-visit-symptoms-table');
            }

        }
    }
</script>

<style scoped>

</style>