<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">

        <div>
          <button class="btn btn-tiny btn-primary" @click="onClickEdit">{{ editButtonText }}</button>
          {{ symptom.symptom_name }}
        </div>
        <div>
          <div v-if="confirmDelete">
            <button class="btn btn-tiny btn-danger" @click="onClickDelete">Confirm</button>
            <button class="btn btn-tiny btn-secondary" @click="onClickCancelDelete">Cancel</button>
          </div>

          <div v-else>
            <button class="btn btn-tiny btn-danger" @click="onClickConfirmDelete">Delete</button>
          </div>
        </div>

      </div>
      <div class="card-body">


        <div v-if="editable" class="edit-form">
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Symptom name</label>
                <input type="text" class="form-control" v-model.trim="symptom.symptom_name">
              </div>
            </div><!-- col -->
          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <RichEditorV2 v-model="symptom.description"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onClickUpdate">Update</button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichEditorV2 v-model="symptom.description" disabled/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>

import RichViewer from "../../../_common/components/RichViewer";
import RichEditor from "../../../_common/components/RichEditor";
import RichEditorV2 from "../../../_common/components/RichEditorV2";

export default {

  name      : "EditSymptom",
  components: { RichEditor, RichViewer, RichEditorV2 },
  props     : [],


  data() {
    return {
      editable          : false,
      symptomDescription: this.$store.getters.getSelectedSymptom.description,

      // delete
      confirmDelete: false,

    }
  },

  computed: {

    symptom: function () {
      this.editable = false;
      return this.$store.getters.getSelectedSymptom;
    },

    editButtonText: function () {
      return this.$store.getters.getEditButtonText;
    }

  },

  watch: {},


  methods: {


    onClickUpdate: function () {

      const symptom = {};

      this.$store.dispatch('updateSymptom', this.symptom)
          .then(() => {
            alert(this.symptom.symptom_name + ' updated');
          })
          .catch(() => {
            alert('Failed to update symptom');
          });

    },

    onClickEdit: function () {
      if ( this.editable ) {
        this.editable = false;
        this.$store.commit('setEditButtonText', 'Edit');
      } else {
        this.editable = true;
        this.$store.commit('setEditButtonText', 'View');
      }
    },


    /*
    * Delete symptom event handlers
    * */

    onClickConfirmDelete: function () {
      this.confirmDelete = true;
    },

    onClickCancelDelete: function () {
      this.confirmDelete = false;
    },

    onClickDelete: function () {

      this.$store.dispatch('deleteSymptom', this.symptom)
          .then(r => {
            this.$store.commit('setPanelModeAdd');
          })
          .catch(e => {
            console.log(e);
          });

    },

  },


}
</script>

<style scoped>

</style>
