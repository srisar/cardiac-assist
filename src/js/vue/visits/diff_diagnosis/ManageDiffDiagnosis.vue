<template>
    <div>
        <div class="text-right mb-2">
            <button class="btn btn-primary" @click="">Add a symptom</button>
        </div>

        <div>

            <div class="alert alert-success" v-if="isEmpty">
                Start adding symptoms for this visit by clicking <a href="#">here</a>.
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
                <tr v-for="diffDiag in diffDiagnoses">
                    <td></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger" ><i class="fas fa-trash"></i></button>
                    </td>
                    <td class="text-center"></td>
                </tr>
                </tbody>

            </table>

        </div>

        <add-diff-diagnosis :event-bus="eventBus" :visit-id="visitId"></add-diff-diagnosis>

    </div>
</template>

<script>

    import AddDiffDiagnosis from "./AddDiffDiagnosis";

    export default {
        name: "ManageDiffDiagnosis",

        components: {
            AddDiffDiagnosis
        },

        data: function () {
            return {
                diffDiagnoses: [],
                visitId: null,

                eventBus: new Vue({})
            }
        },

        computed: {
            isEmpty: function () {
                return _.isEmpty(this.diffDiagnoses);
            }
        },

        mounted() {

            this.visitId = parseInt($("#id_visit").val());
            this.fetchDiffDiagnoses();

            this.eventBus.$on('update-diff-diagnosis-table', this.fetchVisitSymptoms);

        },

        methods: {

            fetchDiffDiagnoses(){

            }

        }

    }
</script>

<style scoped>

</style>