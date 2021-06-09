<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <!-- left -->
        <div>
          <button class="btn btn-tiny" :class="{'btn-secondary': editable, 'btn-primary': !editable}" @click="editable=!editable">{{ editButtonText }}</button>
          {{ selectedInvestigation.investigation_name }}
        </div>

        <!-- right -->
        <div>
          <div v-if="confirmDelete">
            <button class="btn btn-tiny btn-danger" @click="onDelete()">Confirm</button>
            <button class="btn btn-tiny btn-secondary" @click="confirmDelete=false">Cancel</button>
          </div>

          <div v-else>
            <button class="btn btn-tiny btn-danger" @click="confirmDelete=true">Delete</button>
          </div>
        </div>

      </div>
      <div class="card-body">


        <div v-if="editable" class="edit-form">
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Investigation name</label>
                <input type="text" class="form-control" v-model.trim="selectedInvestigation.investigation_name">
              </div>
            </div><!-- col -->


          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <RichEditorV2 v-model="selectedInvestigation.description"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onUpdate()">Update</button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichEditorV2 v-model="selectedInvestigation.description" disabled/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>


import RichEditorV2 from "../../../_common/components/RichEditorV2";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "EditInvestigation",
  components: {RichEditorV2},


  data() {
    return {

      /* editable form */
      editable: false,

      /* delete confirm */
      confirmDelete: false,

      selectedInvestigation: {
        id: undefined,
        investigation_name: "",
        description: ""
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
    await this.fetchSelected(id);

  },

  /*
  * this is needed to catch the id params from the route
  * and fetch the investigation for that id
  * */
  async beforeRouteUpdate(to, from, next) {

    this.editable = false;

    const id = to.params.id;
    await this.fetchSelected(id);

    await next();
  },

  methods: {

    async fetchSelected(id) {
      try {

        await this.$store.dispatch("investigations_fetch", id);
        this.selectedInvestigation = this.$store.getters.getSelectedInvestigation;

      } catch (e) {
        errorMessageBox("Failed to load selected investigation data");
        await this.$router.push("/");
      }
    },

    /*
    * On update
    * */
    async onUpdate() {

      try {

        const params = {
          id: this.selectedInvestigation.id,
          investigation_name: this.selectedInvestigation.investigation_name,
          description: this.selectedInvestigation.description
        }

        await this.$store.dispatch("investigations_update", params);

        await this.$store.dispatch("investigations_fetchAll");

        this.editable = false;

        successMessageBox("Investigation details updated");

      } catch (e) {
        errorMessageBox("Failed to update the investigation");
      }

    },

    /*
    * On delete
    * */

    async onDelete() {

      try {

        await this.$store.dispatch("investigations_delete", this.selectedInvestigation.id);

        await this.$store.dispatch("investigations_fetchAll");

        this.editable = false;

        successMessageBox("Investigation deleted");

        await this.$router.push("/");

      } catch (e) {
        errorMessageBox("Failed to delete the investigation");
      }

    },


  },


}
</script>

<style scoped>

</style>
