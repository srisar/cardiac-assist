<template>

  <div>

    <div class="row">
      <div class="col">

        <div class="card shadow shadow-sm mb-3">
          <div class="card-header">Add an investigation</div>
          <div class="card-body">

            <div class="form-group">
              <label>Investigation</label>
              <select class="custom-select" v-model.number="investigationToAdd.investigation_id" :class="{'is-invalid': isAddFormInvalid}">
                <option value="-1" disabled selected>SELECT ONE</option>
                <option v-for="item in investigationsList" :value="item.id">{{ item.investigation_name }}</option>
              </select>
            </div>

            <p class="text-right">Add a new <a href="/app/investigations/manage.php#/add">investigation</a></p>

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="3" class="form-control" v-model="investigationToAdd.remarks" placeholder="Add useful remarks for the investigation..."></textarea>
            </div>

            <div class="text-center">
              <button class="btn btn-success" :disabled="isAddFormInvalid" @click="onAdd()">Add</button>
            </div>

          </div>
        </div><!-- card -->


        <div class="card shadow shadow-sm">

          <div class="card-header">Further Investigations</div>

          <div class="card-body">

            <table class="table table-sm table-bordered table-hover">
              <tbody>
              <tr v-for="item in furtherInvestigationsList" :key="item.id">
                <td>
                  <p class="font-weight-bold">
                    <a :href="'/app/investigations/manage.php#/edit/' + item.investigation.id" target="_blank">{{ item.investigation.investigation_name }}</a>
                  </p>
                  <div style="white-space: pre-line">{{ item.remarks }}</div>

                  <div class="my-2 d-flex justify-content-between">
                    <div>
                      <button class="btn btn-tiny btn-primary" @click="onOpenEditModal(item)">Edit</button>
                    </div>

                    <div>
                      <button class="btn btn-tiny btn-danger" @click="showDeleteConfirmModal(item)">Remove</button>
                    </div>

                  </div>

                </td>
              </tr>
              </tbody>

            </table>

          </div>

        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->

    <!-- modal: edit -->
    <ModalWindow :visible="isEditModalVisible" @close="isEditModalVisible = false">
      <template v-slot:title>Edit {{ investigationToEdit.investigation.investigation_name }}</template>
      <slot>

        <div class="form-group">
          <label>Investigation</label>
          <select class="custom-select" v-model.number="investigationToEdit.investigation_id">
            <option v-for="item in investigationsList" :value="item.id">{{ item.investigation_name }}</option>
          </select>
        </div>

        <div class="form-group">
          <label>Remarks</label>
          <textarea rows="3" class="form-control" v-model="investigationToEdit.remarks" placeholder="Add useful remarks for the investigation..."></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onUpdate()">Edit</button>
        </div>


      </slot>
    </ModalWindow>
    <!-- end: modal: edit further investigations -->


    <!-- modal: delete confirm -->
    <ModalWindow :visible="isDeleteConfirmModalVisible" @close="isDeleteConfirmModalVisible = false">
      <template v-slot:title>Confirm Removal</template>
      <slot>

        <p class="lead text-center">Confirm removing the following added investigation</p>
        <p class="text-center">{{ investigationToEdit.investigation.investigation_name }}</p>

        <div class="text-center">
          <button class="btn btn-danger" @click="onDelete()">Remove</button>
        </div>

      </slot>
    </ModalWindow>
    <!-- end: modal: delete confirm -->


  </div><!-- template -->

</template>

<script>
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";
import ModalWindow from "../../../_common/components/ModalWindow";

export default {
  name: "FurtherInvestigationsView",
  components: {ModalWindow},
  data() {
    return {

      isEditModalVisible: false,

      isDeleteConfirmModalVisible: false,


      /* all investigations the db */
      investigationsList: [],

      investigationToAdd: {
        investigation_id: -1,
        remarks: ""
      },

      investigationToEdit: {
        id: undefined,
        investigation: {},
        investigation_id: -1,
        remarks: "",
      }

    }
  },


  computed: {

    visitId() {
      return this.$store.getters.getVisitId;
    },

    isAddFormInvalid() {
      return this.investigationToAdd.investigation_id === -1;
    },

    furtherInvestigationsList() {
      return this.$store.getters.getFurtherInvestigationsList;
    }

  },


  filters: {},

  async mounted() {

    try {

      /* 1.fetch all investigations */
      this.$store.dispatch("investigations_fetchAllAvailableInvestigation").then(() => {
        this.investigationsList = this.$store.getters.getInvestigationsList;
      });


      /* 2. fetch all further investigations */
      await this.$store.dispatch("furtherInvestigations_fetchAll", this.visitId);


    } catch (e) {
      errorMessageBox("Failed to load data");
    }

  },

  methods: {

    async onAdd() {

      try {

        const params = {
          visit_id: this.visitId,
          investigation_id: this.investigationToAdd.investigation_id,
          remarks: this.investigationToAdd.remarks
        };

        await this.$store.dispatch("furtherInvestigations_add", params);

        /* fetch added  further investigations */
        await this.$store.dispatch("furtherInvestigations_fetchAll", this.visitId);

      } catch (e) {
        errorMessageBox("Failed to add the investigation");
      }

    },

    onOpenEditModal(item) {

      this.investigationToEdit = _.cloneDeep(item);
      this.isEditModalVisible = true;
    },

    /*
    * On update
    * */
    async onUpdate() {

      try {

        const params = {
          id: this.investigationToEdit.id,
          investigation_id: this.investigationToEdit.investigation_id,
          remarks: this.investigationToEdit.remarks
        };

        await this.$store.dispatch("furtherInvestigations_update", params);

        this.isEditModalVisible = false;
        successMessageBox("Further investigation details updated");

        await this.$store.dispatch("furtherInvestigations_fetchAll", this.visitId);

      } catch (e) {
        errorMessageBox("Failed to update investigation details");
      }

    },

    /*
    * On show delete confirm modal
    * */
    showDeleteConfirmModal(item) {

      this.investigationToEdit = item;
      this.isDeleteConfirmModalVisible = true;

    },

    /*
    * On delete
    * */
    async onDelete() {

      try {

        await this.$store.dispatch("furtherInvestigations_delete", this.investigationToEdit.id);
        await this.$store.dispatch("furtherInvestigations_fetchAll", this.visitId);

        this.isDeleteConfirmModalVisible = false;

      } catch (e) {
        errorMessageBox("Failed to remove selected investigation");
      }

    }

  },

}
</script>

<style scoped>

</style>
