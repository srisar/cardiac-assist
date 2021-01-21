<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        <div class="float-left">
          <button class="btn btn-tiny btn-primary" @click="onClickEdit">{{ editButtonText }}</button>
        </div>
        <div>
          {{ investigation.investigation_name }}

          <div class="float-right">


            <div v-if="confirmDelete">
              <button class="btn btn-tiny btn-danger" @click="onClickDelete">Confirm</button>
              <button class="btn btn-tiny btn-secondary" @click="onClickCancelDelete">Cancel</button>
            </div>

            <div v-else>
              <button class="btn btn-tiny btn-danger" @click="onClickConfirmDelete">Delete</button>
            </div>

          </div><!-- float -->

        </div>
      </div>
      <div class="card-body">


        <div v-if="editable" class="edit-form">
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Investigation name</label>
                <input type="text" class="form-control" v-model.trim="investigation.investigation_name">
              </div>
            </div><!-- col -->


          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <RichEditor :data="investigation.description" @input="getDescription"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onClickUpdate">Update</button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichViewer :data="investigation.description"/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>

import RichViewer from "../../../_common/components/RichViewer";
import RichEditor from "../../../_common/components/RichEditor";

export default {
  name: "EditInvestigation",
  components: {RichEditor, RichViewer},
  props: [],


  data() {
    return {
      editable: false,
      description: this.$store.state.selectedInvestigation.description,

      // delete
      confirmDelete: false,


    }
  },

  computed: {

    investigation: function () {
      this.editable = false;
      return this.$store.state.selectedInvestigation;
    },

    editButtonText: function () {
      return this.$store.state.editButtonText;
    },

  },

  watch: {},


  methods: {

    onClickUpdate: function () {
      this.investigation.description = this.description;

      this.$store.dispatch('updateInvestigation', this.investigation)
          .then(r => {
            alert('Investigation updated');
          })
          .catch(e => {
            alert(e.responseJSON.message);
          });

    },

    onClickEdit: function () {
      if (this.editable) {
        this.editable = false;
        this.$store.commit('setEditButtonText', 'Edit');
      } else {
        this.editable = true;
        this.$store.commit('setEditButtonText', 'View');
      }
    },

    getDescription: function (data) {
      this.description = data;
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

      this.$store.dispatch('deleteInvestigation', this.investigation)
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