<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">

        <!-- left -->
        <div>
          <button class="btn btn-tiny btn-outline-secondary" @click="editable=!editable">
            <img src="/assets/images/actions/edit.svg" class="icon-16" alt=""> {{ editButtonText }}
          </button>
          {{ selectedSymptom.symptom_name }}
        </div>

        <!-- right -->
        <div>
          <div v-if="confirmDelete">
            <button class="btn btn-tiny btn-danger" @click="onDelete()">Confirm</button>
            <button class="btn btn-tiny btn-secondary" @click="confirmDelete=false">Cancel</button>
          </div>

          <div v-else>
            <button class="btn btn-tiny btn-outline-danger" @click="confirmDelete=true">
              <img src="/assets/images/actions/remove.svg" class="icon-16" alt=""> Delete
            </button>
          </div>
        </div>

      </div>
      <div class="card-body">


        <div v-if="editable" class="edit-form">
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Symptom name</label>
                <input type="text" class="form-control" v-model.trim="selectedSymptom.symptom_name">
              </div>
            </div><!-- col -->
          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <RichEditorV2 v-model="selectedSymptom.description"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onUpdate()">
                <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
              </button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichEditorV2 v-model="selectedSymptom.description" disabled/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>

import RichEditorV2 from "../../../_common/components/RichEditorV2";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {

  name: "EditSymptom",
  components: { RichEditorV2 },
  props: [],


  data() {
    return {

      /* editable form */
      editable: false,

      /* delete confirm */
      confirmDelete: false,

      selectedSymptom: {
        id: undefined,
        symptom_name: "",
        description: "",
      }

    }
  },

  computed: {

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

        await this.$store.dispatch( "symptoms_fetch", id );
        this.selectedSymptom = this.$store.getters.getSelectedSymptom;

      } catch ( e ) {
        errorMessageBox( "Failed to load selected investigation data" );
        await this.$router.push( "/" );
      }
    },

    /*
    * On update
    * */
    async onUpdate() {

      try {

        const params = {
          id: this.selectedSymptom.id,
          symptom_name: this.selectedSymptom.symptom_name,
          description: this.selectedSymptom.description
        }

        await this.$store.dispatch( "symptoms_update", params );


        this.editable = false;

        successMessageBox( "Symptom details updated" );

      } catch ( e ) {
        errorMessageBox( "Failed to update the symptom" );
      }

      try {
        await this.$store.dispatch( "symptoms_fetchAll" );
      } catch ( e ) {
        errorMessageBox( "Failed to load symptoms data" );
      }

    },

    /*
    * On delete
    * */
    async onDelete() {

      try {

        await this.$store.dispatch( "symptoms_delete", this.selectedSymptom.id );

        await this.$store.dispatch( "symptoms_fetchAll" );

        this.editable = false;

        successMessageBox( "Symptom deleted" );

        await this.$router.push( "/" );

      } catch ( e ) {
        errorMessageBox( "Failed to delete the symptom" );
      }


    },


  },


}
</script>

<style scoped>

</style>
