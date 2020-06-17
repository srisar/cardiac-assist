<template>

    <div>
        <div class="form-group">
            <label for="field_visit_date">Visit Date</label>
            <input type="date" id="field_visit_date" class="form-control" v-model="visit.visit_date">
        </div>

        <div class="form-group">
            <label for="field_visit_remarks">Visit Remarks</label>
            <textarea id="field_visit_remarks" class="form-control" rows="10" v-model="visit.remarks"></textarea>
        </div>

        <div class="text-right">
            <button class="btn btn-success" @click="updateVisit">Update</button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "EditVisit",
        data() {
            return {
                visit: {
                    id: null,
                    visit_date: null,
                    remarks: null
                }
            }
        },
        mounted() {
            // get the visit id
            this.visit.id = $("#id_visit").val();

            this.fetchVisitDetails();
        },

        methods: {

            /**
             * fetch the initial visit details
             */
            fetchVisitDetails: function() {
                axios
                    .get(`${getSiteUrl()}/api/visit/find?id=${this.visit.id}`)
                    .then(res => {

                        this.visit = res.data.visit;

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    })
            },

            updateVisit: function() {
                axios
                    .post(`${getSiteUrl()}/api/visit/update`, {
                        id: this.visit.id,
                        remarks: this.visit.remarks,
                        visit_date: this.visit.visit_date
                    })
                    .then(res => {

                        showSuccessToast(res.data.message);

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    })
            },

            updateDateField: function(){

            }

        }

    }
</script>

<style scoped>

</style>