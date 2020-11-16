<template>
  <div class="modal"
       :class="{'modal-show' : isVisible, 'modal-hide': !isVisible}"
       id="modal_edit_disease" tabindex="-1" role="dialog"
       aria-labelledby="modal_edit_disease" aria-hidden="true">

    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h3 v-if="selectedDisease" class="modal-title" id="label_edit_symptom_title">{{ selectedDisease.disease }}</h3>
          <button type="button" class="close" @click="hide">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <div v-if="selectedDisease">

            <div class="form-group">
              <label for="field_edit_disease">Disease</label>
              <input type="text" id="field_edit_disease" class="form-control" v-model="selectedDisease.disease">
            </div>

            <div class="form-group">
              <label for="field_edit_disease_code">Disease Code</label>
              <input type="text" id="field_edit_disease_code" v-model="selectedDisease.disease_code">
            </div>

          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btn_update_symptom" @click="update">Update changes</button>
          <button type="button" class="btn btn-secondary" @click="hide">Cancel</button>
          <button type="button" class="btn btn-danger" id="btn_delete_symptom">Delete</button>
        </div>

      </div><!--modal-content-->
    </div><!--modal-dialog-->

  </div>

</template>

<script>

import RichEditor from "../_common/RichEditor";

export default {
  name: "EditDisease",

  components: {RichEditor},

  props: {
    selectedDisease: {
      id: undefined,
      disease: undefined,
      disease_code: undefined
    }
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
    //
  },

  methods: {
    //


    /**
     * update symptom
     */
    update: function () {

      axios.post(`${getSiteUrl()}/api/disease/update`, {

        id: this.selectedDisease.id,
        disease: this.selectedDisease.disease,
        disease_code: this.selectedDisease.disease_code

      }).then(response => {

        showSuccessToast("Disease updated!");
        this.$emit('disease-updated');

        this.hide();


      }).catch(error => {

        console.log(error.response.data);
        showErrorToast('Error updating symptom.')

      })

    },


    hide: function () {
      this.isVisible = false;
      this.$emit('modal-hiding');
    },

    show: function () {
      this.isVisible = true;
      this.$emit('modal-showing');
    },

  }
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