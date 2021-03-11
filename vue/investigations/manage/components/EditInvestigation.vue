<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <!-- left -->
        <div>
          <button class="btn btn-tiny btn-primary" @click="onClickEdit">{{ editButtonText }}</button>
          {{ investigation.investigation_name }}
        </div>

        <!-- right -->
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
                <label>Investigation name</label>
                <input type="text" class="form-control" v-model.trim="investigation.investigation_name">
              </div>
            </div><!-- col -->


          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <RichEditorV2 v-model="investigation.description"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onClickUpdate">Update</button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichEditorV2 v-model="investigation.description" disabled/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>


import RichEditorV2 from "../../../_common/components/RichEditorV2";

export default {
  name      : "EditInvestigation",
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

      this.$store.dispatch('updateInvestigation', this.investigation)
          .then(r => {
            alert('Investigation updated');
          })
          .catch(e => {
            alert(e.responseJSON.message);
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
    * Delete investigations event handlers
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
