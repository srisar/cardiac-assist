<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Investigations

        <div class="float-right" v-if="!addInvestigationPanelVisible">
          <button class="btn btn-tiny btn-success" @click="onShowAddInvestigationPanel">Add</button>
        </div>
      </div><!-- card-header -->

      <div class="card-body">

        <!-- add investigation form -->
        <div id="form-add-investigation" v-if="addInvestigationPanelVisible">

          <div class="alert alert-secondary">

            <div class="form-row">
              <div class="col">

                <div class="form-group">
                  <label>Investigation</label>
                  <select class="form-control" v-model="investigationToAdd.investigation_id">
                    <option value="-1" disabled>SELECT</option>
                    <option v-for="item in investigationsList" :value="item.id">{{ item.investigation_name }}</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <RichEditor @input="getDescription"/>
                </div>

                <div class="form-group text-center">
                  <button class="btn btn-success" @click="onAddInvestigation" :disabled="!isSaveFormValid">Add</button>
                  <button class="btn btn-secondary" @click="onHideAddInvestigationPanel">Close</button>
                </div>

              </div>
            </div><!-- row -->

          </div><!-- alert -->

        </div><!-- add investigation form -->


        <!-- investigations list -->
        <div class="my-3">
          <table class="table table-bordered table-sm">
            <thead>
            <tr>
              <th>Investigation</th>
              <th style="width: 50px" class="text-center">Description</th>
              <th style="width: 100px" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item) in visitInvestigationsList">
              <td>{{ item.investigation.investigation_name }}</td>
              <td class="text-center">
                <button class="btn btn-tiny btn-secondary">View</button>
              </td>
              <td class="text-center"></td>
            </tr>
            </tbody>
          </table>
        </div><!-- investigations list -->


      </div><!-- card-body -->

    </div><!-- card -->

  </div><!-- template -->

</template>

<script>
import RichEditor from "../../_common/components/RichEditor";

const _ = require('lodash');

export default {
  name: "VisitInvestigations",
  components: {RichEditor},

  /*
  * DATA
  * */
  data() {
    return {
      addInvestigationPanelVisible: false,

      investigationToAdd: {
        visit_id: -1, // needs to be set when saving or updating the visit symptoms
        investigation_id: -1,
        description: "",
      },

    }
  },

  /*
  * COMPUTED
  * */
  computed: {

    visitInvestigationsList: function () {
      return this.$store.getters.getVisitInvestigationsList;
    },

    investigationsList: function () {
      return this.$store.getters.getInvestigationsList;
    },

    isSaveFormValid: function () {
      return this.investigationToAdd.investigation_id !== -1;
    },


  },

  /*
  * MOUNTED
  * */
  mounted() {

    /*
    * Fetch investigations for the dropdown
    * */
    this.$store.dispatch('fetchInvestigations')
        .catch(e => {
          console.log(e);
        });

  },

  /*
  * METHODS
  * */
  methods: {


    onShowAddInvestigationPanel: function () {
      this.addInvestigationPanelVisible = true;
    },

    onHideAddInvestigationPanel: function () {
      this.addInvestigationPanelVisible = false;
    },

    getDescription: function (data) {
      this.investigationToAdd.description = data;
    },


    onAddInvestigation: function () {

      this.investigationToAdd.visit_id = this.$store.state.visit.id;

      // TODO: check if investigation is already added

      this.$store.dispatch('addVisitInvestigation', this.investigationToAdd)
          .then(() => {

            alert('Investigation added');

            // clearing out the form
            this.investigationToAdd = {
              investigation_id: -1,
              description: "",
            };

          })
          .catch(() => {
            alert('Failed to add investigation');
          });

    },

    /*
    *
    * HELPERS
    * */


  },

}
</script>

<style scoped>

</style>
