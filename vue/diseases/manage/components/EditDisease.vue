<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">

        <!-- left side -->
        <div>
          <button class="btn btn-tiny btn-primary" @click="onClickEdit">{{ editButtonText }}</button>
          {{ disease.disease }}
        </div>

        <!-- right side -->
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
                <label>Disease name</label>
                <input type="text" class="form-control" v-model.trim="disease.disease">

              </div>
            </div><!-- col -->

            <div class="col">
              <div class="form-group">
                <label>Disease code</label>
                <input type="text" class="form-control" v-model.trim="disease.disease_code">
              </div>
            </div><!-- col -->

          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <RichEditorV2 v-model="disease.description"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onClickUpdate">Update</button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichEditorV2 v-model="disease.description" disabled/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>

import RichEditorV2 from "../../../_common/components/RichEditorV2";

export default {
  name      : "EditDisease",
  components: { RichEditorV2 },
  props     : [],


  data() {
    return {
      editable: false,

      // delete
      confirmDelete: false,

    }
  },

  computed: {

    disease: function () {
      this.editable = false;
      return this.$store.getters.getSelectedDisease;
    },

    editButtonText: function () {
      return this.$store.getters.getEditButtonText;
    },

  },

  watch: {},


  methods: {

    onClickUpdate: function () {

      const disease = {
        id          : this.disease.id,
        disease     : this.disease.disease,
        disease_code: this.disease.disease_code,
        description : this.disease.description
      };

      this.$store.dispatch('updateDisease', disease)
          .then(r => {
            alert('Disease updated');
          })
          .catch(e => {
            alert('Update failed');
            console.log(e);
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
   * Delete disease event handlers
   * */

    onClickConfirmDelete: function () {
      this.confirmDelete = true;
    },

    onClickCancelDelete: function () {
      this.confirmDelete = false;
    },

    onClickDelete: function () {

      this.$store.dispatch('deleteDisease', this.disease)
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
