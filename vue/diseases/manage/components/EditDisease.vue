<template>

  <div v-if="selectedDisease">

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">

        <!-- left side -->
        <div>
          <button class="btn btn-tiny btn-outline-dark" @click="editable=!editable">
            <img src="/assets/images/actions/edit.svg" class="icon-16" alt=""> {{ editButtonText }}
          </button>
          {{ selectedDisease.disease }}
        </div>

        <!-- right side -->
        <div>
          <div v-if="confirmDelete">
            <button class="btn btn-tiny btn-danger" @click="onDelete()">Confirm</button>
            <button class="btn btn-tiny btn-secondary" @click="confirmDelete = false">Cancel</button>
          </div>

          <div v-else>
            <button class="btn btn-tiny btn-danger" @click="confirmDelete = true">Delete</button>
          </div>
        </div>

      </div>

      <div class="card-body">


        <div v-if="editable" class="edit-form">
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Disease name</label>
                <input type="text" class="form-control" v-model.trim="selectedDisease.disease">

              </div>
            </div><!-- col -->

            <div class="col">
              <div class="form-group">
                <label>Disease code</label>
                <input type="text" class="form-control" v-model.trim="selectedDisease.disease_code">
              </div>
            </div><!-- col -->

          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <RichEditorV2 v-model="selectedDisease.description"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onUpdate()">Update</button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichEditorV2 v-model="selectedDisease.description" disabled/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>

import RichEditorV2 from "../../../_common/components/RichEditorV2";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "EditDisease",
  components: { RichEditorV2 },


  data() {
    return {
      editable: false,
      /* delete confirm */
      confirmDelete: false,


    }
  },

  computed: {

    selectedDisease() {
      return this.$store.getters.getSelectedDisease;
    },

    editButtonText: function () {
      return this.editable ? "Cancel" : "Edit";
    },

  },

  async mounted() {
    const id = this.$route.params.id;
    await this.fetchSelected( id );
  },

  async beforeRouteUpdate( to, from, next ) {

    const id = to.params.id;
    await this.fetchSelected( id );
    await next();

  },

  methods: {


    async fetchSelected( id ) {
      try {

        await this.$store.dispatch( "diseases_fetch", id );

      } catch ( e ) {
        errorMessageBox( "Failed to load selected investigation data" );
        await this.$router.push( "/" );
      }
    },

    async onUpdate() {


      try {
        const params = {
          id: this.selectedDisease.id,
          disease: this.selectedDisease.disease,
          disease_code: this.selectedDisease.disease_code,
          description: this.selectedDisease.description
        };

        await this.$store.dispatch( 'diseases_update', params );

        successMessageBox( "Disease details updated" );

      } catch ( e ) {
        errorMessageBox( "Failed to update disease details" );
      }

      try {
        await this.$store.dispatch( "diseases_fetchAll" );
      } catch ( e ) {
        errorMessageBox( "Failed to fetch disease details" );
      }


    },


    async onDelete() {

      try {
        await this.$store.dispatch( 'diseases_delete', this.selectedDisease.id );
        await this.$store.dispatch( "diseases_fetchAll" );

        this.editable = false;

        successMessageBox( "Disease deleted" );

        await this.$router.push( "/" );

      } catch ( e ) {
        errorMessageBox( "Failed to delete the disease" );
      }

    },


  },


}
</script>

<style scoped>

</style>
