<template>
    <div class="container-fluid">

        <div class="row justify-content-center">

            <!--
            |
            | start section: add a symptom
            |
            -->
            <div class="col-12 col-lg-4">

                <add-disease :event-bus="eventBus"></add-disease>

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
                                <th>Disease</th>
                                <th>Disease code</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="disease in diseases">
                                <td>{{disease.disease}}</td>
                                <td>{{disease.disease_code}}</td>
                                <td style="width: 50px">
                                    <button @click="" class="btn btn-sm btn-primary">
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


    </div><!--container-->
</template>

<script>

    import AddDisease from "./AddDisease";

    export default {
        name: "ManageDiseases",
        components: {
            AddDisease
        },
        data() {
            return {
                diseases: undefined,
                disease: {
                    disease: "",
                    disease_code: ""
                },
                eventBus: new Vue({}),
            };
        },
        mounted() {
            this.fetchDiseases();
        },
        methods: {

            fetchDiseases: function () {

                axios.get(`${getSiteUrl()}/api/disease/all`)
                    .then(response => {

                        this.diseases = response.data.diseases;

                    }).catch(error => {
                    showErrorToast("Failed to load diseases");
                    console.log(error.response.data);
                });

            },

        },
    }
</script>

<style scoped>

</style>