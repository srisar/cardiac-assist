<template>

  <div>
    <ModalWindow ref="editModal" id="editModal">
      <template v-slot:title>Edit symptom: {{ selectedSymptom.symptom_name }}</template>

      <section>
        <div class="form-group">
          <label for="field_edit_disease">Symptom name</label>
          <input type="text" id="field_edit_disease" class="form-control" v-model="selectedSymptom.symptom_name">
        </div>

        <div class="form-group">
          <label for="field_description">Description</label>
          <RichEditor id="field_description" v-model="selectedSymptom.description"></RichEditor>
        </div>
      </section>


      <template v-slot:footer>
        <button type="button" class="btn btn-success" id="btn_update_symptom" :disabled="isEmptySymptomName" @click="update">Update changes</button>
      </template>


    </ModalWindow>
  </div>

</template>

<script>

import RichEditor from "../../_common/RichEditor";
import ModalWindow from "../../_common/ModalWindow";

export default {
  name: "EditSymptom",

  components: {
    RichEditor,
    ModalWindow
  },

  props: {
    selectedSymptom: {
      id: undefined,
      symptom_name: undefined,
      description: undefined,
    },
  },

  data: function () {
    return {}
  },

  computed: {

    isEmptySymptomName: function () {
      return _.isEmpty(this.selectedSymptom.symptom_name);
    },

  },


  methods: {
    /**
     * update symptom
     */
    update: function () {

      axios.post(`${getSiteUrl()}/api/symptom/update`, {

        id: this.selectedSymptom.id,
        symptom_name: this.selectedSymptom.symptom_name,
        description: this.selectedSymptom.description

      }).then(response => {

        showSuccessToast("Symptom updated!");
        this.$emit('symptom-updated');


      }).catch(error => {

        console.log(error.response.data);
        showErrorToast('Error updating symptom.')

      })

    },

    show: function () {
      this.$refs.editModal.show();
    }


  },
}
</script>

<style scoped>

.modal {
  background-color: rgba(108, 117, 125, 0.5);
}

.modal-show {
  display: block;
}

.modal-hide {
  display: none;
}
</style>