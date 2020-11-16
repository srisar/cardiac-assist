<template>
  <div class="modal" :class="{'modal-show' : isVisible, 'modal-hide': !isVisible}" id="modal_edit_symptom" tabindex="-1" role="dialog" aria-labelledby="modal_edit_symptom" aria-hidden="false">

    <div class="modal-dialog">
      <div class="modal-content shadow shadow-lg">
        <div class="modal-header">
          <h3 v-if="selectedSymptom" class="modal-title" id="label_edit_symptom_title">{{ selectedSymptom.symptom_name }}</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="hide">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div v-if="selectedSymptom">

            <div class="form-group">
              <label for="field_edit_symptom_name">Symptom name <span class="badge badge-danger">{{ symptomNameError }}</span></label>
              <input v-if="selectedSymptom" type="text" id="field_edit_symptom_name" class="form-control" v-model="selectedSymptom.symptom_name">
            </div>

            <div class="form-group">
              <label>Description</label>
              <rich-editor :content="selectedSymptom.description" v-on:content-updated="getDescription"></rich-editor>
            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btn_update_symptom" @click="update">Update changes</button>
          <button type="button" class="btn btn-secondary" @click="hide">Cancel</button>
          <button type="button" class="btn btn-danger" id="btn_delete_symptom">Delete</button>
        </div>
      </div>
    </div><!--modal-dialog-->

  </div>

</template>

<script>

import RichEditor from "../../_common/RichEditor";

export default {
  name: "EditSymptom",

  components: {
    RichEditor
  },

  props: {
    selectedSymptom: {
      id: "",
      symptom_name: "",
      description: "",
    },
  },

  data: function () {
    return {
      isVisible: false,
      error: {
        symptom_name: ""
      }
    }
  },

  computed: {
    symptomNameError: function () {
      if (this.selectedSymptom.symptom_name === "") return "Invalid symptom name";
      return "";
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

        this.hide();


      }).catch(error => {

        console.log(error.response.data);
        showErrorToast('Error updating symptom.')

      })

    },




    getDescription: function (data) {
      this.selectedSymptom.description = data;
    },

    hide: function () {
      this.isVisible = false;
      this.$emit('modal-hiding');
    },

    show: function () {
      this.isVisible = true;
      this.$emit('modal-showing');
    },


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