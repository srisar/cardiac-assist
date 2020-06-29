<template>
    <div class="container-fluid">

        <div class="row justify-content-center">

            <!--
            |
            | start section: add a symptom
            |
            -->
            <div class="col-12 col-lg-4">

                <add-symptom :event-bus="eventBus"></add-symptom>

            </div><!--col-->

            <!--
            |
            | start section: add a symptom
            |
            -->
            <div class="col-12 col-lg-8">

                <div class="card">
                    <div class="card-header">Existing symptoms</div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped" id="table_symptoms">
                            <thead>
                            <tr>
                                <th>Symptom</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="symptom in symptoms">
                                <td>{{symptom.symptom_name}}</td>
                                <td>{{symptom.description}}</td>
                                <td style="width: 50px">
                                    <button @click="btnShowEditModalOnClick(symptom)" class="btn btn-sm btn-primary">
                                        <i class="fad fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>

                        </table>

                    </div>
                </div>

            </div><!--col-->

        </div><!--row-->


        <edit-symptom :selected-symptom="selectedSymptom" :event-bus="eventBus"></edit-symptom>

    </div><!--container-->
</template>

<script>

    import EditSymptom from "./EditSymptom";
    import AddSymptom from "./AddSymptom";

    export default {
        name: "ManageSymptoms",
        components: {
            EditSymptom,
            AddSymptom
        },
        data() {
            return {
                symptoms: {},
                table: undefined,
                selectedSymptom: undefined,
                eventBus: new Vue({}),
            };
        },
        computed: {},
        mounted() {
            /**
             * getting all the symptoms
             */
            this.fetchSymptoms();

            this.eventBus.$on('symptom-updated', this.fetchSymptoms);
            this.eventBus.$on('symptom-added', this.fetchSymptoms);

        },
        methods: {

            /**
             * fetch all symptoms
             */
            fetchSymptoms() {

                console.log("fetching....");

                axios.get(`${getSiteUrl()}/api/symptom/all`)
                    .then(response => {
                        return response.data;
                    })
                    .then(data => {

                        this.symptoms = data.symptoms;
                    })
                    .catch(error => {

                        console.log(error);

                    });

            },


            showEditModal() {
                $("#modal_edit_symptom").modal("show");
            },

            btnShowEditModalOnClick(symptom) {
                this.selectedSymptom = symptom;

                $("#modal_edit_symptom").modal("show");

            }


        }
    }
</script>

<style scoped>

</style>