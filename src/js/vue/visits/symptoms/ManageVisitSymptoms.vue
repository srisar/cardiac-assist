<template>
    <div>
        <div class="text-right mb-2">
            <button class="btn btn-primary">Add a symptom</button>
        </div>

        <div>

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th>Symptom</th>
                    <th>Remove</th>
                    <th>Actions</th>
                </tr>
                </thead>



            </table>

        </div>

        <add-visit-symptom></add-visit-symptom>

    </div>
</template>

<script>

    import AddVisitSymptom from "./AddVisitSymptom";

    export default {
        name: "ManageVisitSymptoms",

        components: {
            AddVisitSymptom
        },

        data(){
            return {
                visitSymptoms: {},
                visitId: null
            };
        },

        mounted() {

            this.visitId = parseInt($("#id_visit").val());
            this.fetchVisitSymptoms();
        },

        methods: {
            fetchVisitSymptoms(){

            }
        }
    }

</script>

<style scoped>

</style>