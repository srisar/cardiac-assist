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
                    <option v-for="item in investigationsList" :value="item.id" :disabled="disableIfExistingInvestigation(item)">
                      {{ item.investigation_name }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Remarks</label>
                  <RichEditorV2 v-model="investigationToAdd.remarks"/>
                </div>

                <div class="form-group text-center">
                  <button class="btn btn-success" @click="onAddInvestigation" :disabled="!isSaveFormValid">Add</button>
                  <button class="btn btn-secondary" @click="onHideAddInvestigationPanel">Close</button>
                </div>

              </div>
            </div><!-- row -->

          </div><!-- alert -->

        </div><!-- add investigation form -->

        <!-- view visit investigation -->
        <div id="view-single-visit-investigation" v-if="viewInvestigationPanelVisible">

          <div class="alert alert-success">
            <div class="form-row">
              <div class="col">

                <div class="form-group">
                  <label>Investigation</label>
                  <input type="text" class="form-control bg-white" readonly
                         v-model="selectedInvestigation.investigation.investigation_name">
                </div>

                <div class="form-group">
                  <label>Remarks</label>
                  <RichEditorV2 v-model="selectedInvestigation.remarks"/>
                </div>

                <div class="form-group text-center clearfix">
                  <div class="float-left">
                    <button class="btn btn-success" @click="onUpdateInvestigation">Update</button>
                    <button class="btn btn-secondary" @click="onHideViewInvestigationPanel">Close</button>
                  </div>
                  <div class="float-right">
                    <span class="text-danger">Caution!</span>
                    <button class="btn btn-danger" @click="onDeleteInvestigation">Delete</button>
                  </div>
                </div>

              </div>
            </div><!-- row -->
          </div><!-- row -->

        </div><!-- view visit investigation -->


        <!-- investigations list -->
        <div id="visit-investigations-list" class="my-3">
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
              <td><a href="#view-single-visit-investigation" @click="onSelectViewInvestigationPanel(item)">{{ item.investigation.investigation_name }}</a></td>
              <td class="text-center">
                <a class="btn btn-tiny btn-secondary" :href="createViewInvestigationLink(item)">View</a>
              </td>
              <td class="text-center">
                <button class="btn btn-tiny btn-primary" @click="onSelectViewInvestigationPanel(item)">Edit</button>
                <button class="btn btn-danger btn-tiny" @click="onDeleteInvestigation(item)">Delete</button>
              </td>
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
import RichEditorV2 from "../../_common/components/RichEditorV2";

const _ = require('lodash');

export default {
  name: "VisitInvestigations",
  components: {RichEditor, RichEditorV2},

  /*
  * DATA
  * */
  data() {
    return {
      addInvestigationPanelVisible: false,
      viewInvestigationPanelVisible: false,

      investigationToAdd: {
        visit_id: -1, // needs to be set when saving or updating the visit symptoms
        investigation_id: -1,
        remarks: "",
      },

      selectedInvestigation: {
        visit_id: -1,
        investigation_id: -1,
        remarks: "",
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


    onAddInvestigation: function () {

      const investigation = {
        visit_id: this.$store.state.visit.id,
        investigation_id: this.investigationToAdd.investigation_id,
        remarks: this.investigationToAdd.remarks
      }

      console.table(investigation);

      this.$store.dispatch('addVisitInvestigation', investigation)
          .then(() => {

            alert('Investigation added');

            // clearing out the form
            this.investigationToAdd = {
              investigation_id: -1,
              remarks: "",
            };

          })
          .catch(() => {
            alert('Failed to add investigation');
          });

    },

    /*
    * Update selected visit investigation
    * */
    onUpdateInvestigation: function () {

      const investigation = {
        id: this.selectedInvestigation.id,
        remarks: this.selectedInvestigation.remarks,
      }

      this.$store.dispatch('updateVisitInvestigation', investigation)
          .then(() => {
            alert('Investigation remarks updated');
          })
          .catch(() => {
            alert('Failed to update investigation remarks');
          });

    },

    onDeleteInvestigation: function () {

      const investigation = {
        id: this.selectedInvestigation.id,
      }

      this.$store.dispatch('deleteVisitInvestigation', investigation)
          .then(() => {

            this.viewInvestigationPanelVisible = false;

          })
          .catch(() => {
            alert('Failed to delete visit investigation');
          });

    },

    /*
    *
    * HELPERS
    * */

    createViewInvestigationLink: function (investigation) {
      return `${getSiteURL()}/app/investigations/view.php?id=${investigation.id}`;
    },

    onShowAddInvestigationPanel: function () {
      this.addInvestigationPanelVisible = true;
    },

    onHideAddInvestigationPanel: function () {
      this.addInvestigationPanelVisible = false;
    },

    /*
    * Handle visit investigation selection,
    * 1. set selected investigation
    * 2. set investigation remarks
    * */
    onSelectViewInvestigationPanel: function (investigation) {

      this.selectedInvestigation = investigation;
      this.selectedInvestigation.updatedRemarks = investigation.remarks;

      this.viewInvestigationPanelVisible = true;
    },

    onHideViewInvestigationPanel: function () {
      this.viewInvestigationPanelVisible = false;
    },

    disableIfExistingInvestigation(investigation) {

      const i = _.find(this.visitInvestigationsList, (o) => {
        return o.investigation_id === investigation.id;
      });

      if (i === undefined) return false;
      else return true;
    }

  },

}
</script>

<style scoped>

</style>
