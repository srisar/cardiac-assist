<template>
    <div>
        <div class="text-right mb-2">
            <button class="btn btn-primary" @click="showAddVisitSymptomsModal">Add a symptom</button>
        </div>

        <div>

            <div class="alert alert-success" v-if="isEmpty">
                Start adding symptoms for this visit by clicking <a href="#" @click="showAddVisitSymptomsModal">here</a>.
            </div>

            <table class="table table-bordered" v-if="!isEmpty">

                <thead>
                <tr>
                    <th>Symptom</th>
                    <th style="width: 50px;">Remove</th>
                    <th style="width: 50px">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="visitSymptom in visitSymptoms">
                    <td>{{visitSymptom.symptom.symptom_name}}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger" @click="removeVisitSymptom(visitSymptom)"><i class="fas fa-trash"></i></button>
                    </td>
                    <td class="text-center"></td>
                </tr>
                </tbody>

            </table>

        </div>

        <add-visit-symptom :event-bus="eventBus" :visit-id="visitId"></add-visit-symptom>

    </div>
</template>

<script>

    import AddVisitSymptom from "./AddVisitSymptom";

    export default {
        name: "ManageVisitSymptoms",

        components: {
            AddVisitSymptom
        },

        data() {
            return {
                visitSymptoms: {},
                visitId: null,

                eventBus: new Vue({}),
            };
        },

        computed: {
            isEmpty: function () {
                return _.isEmpty(this.visitSymptoms);
            }
        },

        mounted() {

            this.visitId = parseInt($("#id_visit").val());
            this.fetchVisitSymptoms();

            this.eventBus.$on('update-visit-symptoms-table', this.fetchVisitSymptoms);

        },

        methods: {

            /**
             * show add visit symptom modal
             */
            showAddVisitSymptomsModal: function () {
                $("#modal_add_visit_symptoms").modal("show");
            },

            /**
             * fetch visit symptoms
             */
            fetchVisitSymptoms: function () {

                axios
                    .get(`${getSiteUrl()}/api/visit-symptom/by-visit?id=${this.visitId}`)
                    .then(res => {

                        this.visitSymptoms = res.data.visit_symptoms;

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    });

            },

            /**
             * remove symptom from visit
             */
            removeVisitSymptom: function (visitSymptom) {

                axios
                    .post(`${getSiteUrl()}/api/visit-symptom/delete`, {
                        id: visitSymptom.id
                    })
                    .then(res => {

                        showSuccessToast(`${visitSymptom.symptom.symptom_name}`);

                        this.fetchVisitSymptoms();

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    });

            }

        }
    }

</script>

<style scoped>

</style>