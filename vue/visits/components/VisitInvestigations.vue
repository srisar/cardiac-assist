<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Investigations
        <div class="float-right">
          <button class="btn btn-tiny btn-success" @click="onShowAddModal">Add</button>
        </div>
      </div><!-- card-header -->

      <div class="card-body">

        <!-- investigations list -->
        <div id="visit-investigations-list" class="">

          <table class="table table-bordered table-sm" v-if="!isEmpty">
            <thead>
            <tr>
              <th>Investigation</th>
              <th style="width: 70%">Remarks</th>
              <th style="width: 100px" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item) in visitInvestigationsList">
              <td><a href="#">{{ item.investigation.investigation_name }}</a></td>
              <td>
                <pre>{{ item.remarks }}</pre>
              </td>
              <td class="text-center">
                <button class="btn btn-tiny btn-primary" @click="onShowEditModal(item)"><i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-danger btn-tiny" @click="onDelete(item)"><i class="bi bi-trash-fill"></i>
                </button>
              </td>
            </tr>
            </tbody>
          </table>

          <div v-else>
            <p>No items. Start adding investigations.</p>
          </div>

        </div><!-- investigations list -->

      </div><!-- card-body -->
    </div><!-- card -->


    <!-- MODAL Add Investigation -->
    <ModalWindow id="modal-add-visit-investigation" :visible="modalAddVisible" @close="onCloseAddModal">
      <template v-slot:title>Add common investigations</template>
      <slot>

        <!-- section : add symptom -->
        <div class="row">
          <div class="col">

            <div class="form-group">
              <select class="form-control" v-model="investigationToAdd.investigation_id">
                <option value="-1" disabled>SELECT</option>
                <option v-for="item in investigationsList" :disabled="existingInvestigation(item)" :value="item.id">
                  {{ item.investigation_name }}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="5" class="form-control" v-model="investigationToAdd.remarks"></textarea>
            </div>


          </div><!-- col -->
        </div><!-- row -->
        <!-- section: add symptom -->

      </slot>

      <template v-slot:footer>
        <div class="row">
          <div class="col">
            <button class="btn btn-success" @click="onAdd" :disabled="!isSaveFormValid">Add</button>
          </div>
        </div>
      </template><!-- footer -->

    </ModalWindow>


    <ModalWindow id="modal-edit-investigation" :visible="modalEditVisible" @close="onCloseEditModal">
      <template v-slot:title v-if="modalEditVisible">Add common investigations</template>
      <slot v-if="modalEditVisible">

        <!-- section : add symptom -->
        <div class="row">
          <div class="col">

            <div class="form-group">
              <label>Investigation</label>
              <input type="text" readonly class="form-control" :value="selectedVisitInvestigation.investigation_name">
            </div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="5" class="form-control" v-model="selectedVisitInvestigation.remarks"></textarea>
            </div>


          </div><!-- col -->
        </div><!-- row -->
        <!-- section: add symptom -->

      </slot>

      <template v-slot:footer>
        <div class="row">
          <div class="col">
            <button class="btn btn-success" @click="onUpdate">Update</button>

            <span v-if="confirmDelete">
              <button class="btn btn-danger"
                      @click="onDelete({id: selectedVisitInvestigation.id}) & (confirmDelete = false)">Confirm</button>
              <button class="btn btn-secondary" @click="confirmDelete = !confirmDelete">Cancel</button>
            </span>
            <span v-else>
              <button class="btn btn-danger" @click="confirmDelete = true">Delete</button>
            </span>

          </div>
        </div>
      </template><!-- footer -->

    </ModalWindow>


  </div><!-- template -->

</template>

<script>
import RichEditorV2 from "../../_common/components/RichEditorV2";
import ModalWindow from "../../_common/components/ModalWindow";

const _ = require('lodash');

export default {
  name: "VisitInvestigations",
  components: {ModalWindow, RichEditorV2},

  /*
  * DATA
  * */
  data() {
    return {
      modalAddVisible: false,
      modalEditVisible: false,

      confirmDelete: false,

      investigationToAdd: {
        visit_id: undefined, // needs to be set when saving or updating the visit investigation
        investigation_id: -1,
        remarks: "",
      },

      selectedVisitInvestigation: {
        id: undefined,
        investigation_name: "",
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


    isEmpty: function () {
      return this.visitInvestigationsList.length === 0;
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


    onAdd: function () {

      const investigation = {
        visit_id: this.$store.state.visit.id,
        investigation_id: this.investigationToAdd.investigation_id,
        remarks: this.investigationToAdd.remarks
      }

      console.table(investigation);

      this.$store.dispatch('addVisitInvestigation', investigation)
          .then(() => {

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
    onUpdate: function () {

      const visitInvestigation = {
        id: this.selectedVisitInvestigation.id,
        remarks: this.selectedVisitInvestigation.remarks,
      }

      this.$store.dispatch('updateVisitInvestigation', visitInvestigation)
          .then(() => {
          })
          .catch(() => {
            alert('Failed to update investigation remarks');
          });

    },

    onDelete: function (item) {

      const investigation = {
        id: item.id,
      }

      this.$store.dispatch('deleteVisitInvestigation', investigation)
          .then(() => {
            this.onCloseEditModal();
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


    /*
    * Check if investigation from the dropdown already added
    * */
    existingInvestigation(investigation) {

      const i = _.find(this.visitInvestigationsList, (o) => {
        return o.investigation_id === investigation.id;
      });

      return i !== undefined;
    },

    /*
    *
    * Modal event handlers
    * */
    onShowAddModal: function () {
      this.modalAddVisible = true;
    },

    onCloseAddModal: function () {
      this.modalAddVisible = false;
    },

    /*
    * Show edit selected investigation modal
    * */
    onShowEditModal: function (item) {

      console.table(item);

      this.selectedVisitInvestigation.id = item.id;
      this.selectedVisitInvestigation.investigation_name = item.investigation.investigation_name;
      this.selectedVisitInvestigation.remarks = item.remarks;

      this.modalEditVisible = true;
    },

    onCloseEditModal: function () {
      this.selectedVisitInvestigation.id = undefined;
      this.selectedVisitInvestigation.investigation_name = "";
      this.selectedVisitInvestigation.remarks = "";

      this.modalEditVisible = false;
    },


  },

}
</script>

<style scoped>

</style>
