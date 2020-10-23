<template>
    <div class="modal fade" id="modal_edit_symptom" tabindex="-1" role="dialog" aria-labelledby="modal_edit_symptom" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="label_edit_symptom_title"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div v-if="selectedSymptom">

                        <div class="form-group">
                            <label for="field_edit_symptom_name">Symptom name</label>
                            <input type="text" id="field_edit_symptom_name" class="form-control" value="" v-model="selectedSymptom.symptom_name">
                        </div>

                        <div class="form-group">
                            <label for="field_edit_description">Description</label>
                            <textarea id="field_edit_description" rows="10" class="form-control" v-model="selectedSymptom.description"></textarea>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_update_symptom" @click="update">Update changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="btn_delete_symptom">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditSymptom",
        props: {
            selectedSymptom: {
                id: "",
                symptom_name: "",
                description: "",
            },
            eventBus: undefined
        },
        methods: {
            /**
             * update symptom
             */
            update() {

                axios.post(`${getSiteUrl()}/api/symptom/update`, {

                    id: this.selectedSymptom.id,
                    symptom_name: this.selectedSymptom?.symptom_name,
                    description: this.selectedSymptom?.description

                }).then(response => {

                    showSuccessToast("Symptom updated!");
                    this.emitUpdatedEvent();

                    $("#modal_edit_symptom").modal("hide");

                }).catch(error => {

                    console.log(error.response.data);

                })

            },


            emitUpdatedEvent() {
                this.eventBus.$emit("symptom-updated");
            }

        },
    }
</script>

<style scoped>

</style>