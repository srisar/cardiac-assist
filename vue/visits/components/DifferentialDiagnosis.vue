<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Differential Diagnoses</div>
        <div>
          <button class="btn btn-tiny btn-success" @click="modalAddVisible = true">Add</button>
        </div>

      </div><!-- card-header -->

      <div class="card-body">


        <table class="table table-sm table-hover table-bordered" v-if="!isEmpty">

          <tbody>
          <tr v-for="item in diffDiagnosisList" :key="item.id">


            <td>

              <p class="font-weight-bold"><a href="#">{{ item.disease.disease }}</a> ({{ item.disease.disease_code }})</p>
              <div style="white-space: pre-line">{{ item.remarks }}</div>


              <div class="my-2 d-flex justify-content-between">
                <div>
                  <button class="btn btn-tiny btn-primary" @click="onShowEditModal(item)">Edit</button>
                </div>

                <div>
                  <button class="btn btn-tiny btn-danger" @click="onShowDeleteConfirmModal(item)">Remove</button>
                </div>

              </div>

            </td>

          </tr>
          </tbody>
        </table>

        <div v-else>
          <p>No items. Start adding some differential diagnoses</p>
        </div>

      </div><!-- card-body -->

    </div><!-- card -->


    <!-- Modal Add Diff Diagnosis -->
    <ModalWindow id="modal-add-diff-diagnosis" :visible="modalAddVisible" @close="modalAddVisible = false">
      <template v-slot:title>Add a differential diagnosis</template>
      <slot>

        <div class="form-row">

          <div class="col">

            <div class="form-group">
              <label>Disease</label>
              <select class="form-control" v-model="diffDiagnosisToAdd.disease">
                <option value="-1" disabled>SELECT</option>
                <option v-for="item in diseasesList" :value="item">{{ item.disease }}</option>
              </select>
            </div>

          </div><!-- col -->

        </div><!-- row -->


        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="5" class="form-control" v-model="diffDiagnosisToAdd.remarks"></textarea>
            </div>

          </div><!-- col -->
        </div><!-- row -->

        <div class="form-row">
          <div class="col text-center">

            <button class="btn btn-success" @click="onAdd()">Add</button>

          </div>
        </div>

      </slot>
    </ModalWindow><!-- Modal Add Diff Diagnosis -->

    <!-- ------------------------------------------------------------------------------------------------------------ -->

    <!-- Modal Edit Diff Diagnosis -->
    <ModalWindow id="modal-edit-diff-diagnosis" :visible="modalEditVisible" @close="modalEditVisible = false">
      <template v-slot:title v-if="diffDiagnosisToEdit">Edit {{ diffDiagnosisToEdit.disease.disease }}</template>
      <slot v-if="diffDiagnosisToEdit">

        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Disease</label>
              <input class="form-control" type="text" readonly :value="diffDiagnosisToEdit.disease.disease">
            </div>

            <div class="w-100"></div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" rows="5" v-model="diffDiagnosisToEdit.remarks"></textarea>
            </div>

          </div><!-- col -->
        </div><!-- row -->

        <div class="row">
          <div class="col text-center">
            <button class="btn btn-success" @click="onUpdate()">Update</button>
          </div>
        </div>

      </slot>
    </ModalWindow><!-- Modal Edit Diff Diagnosis -->


    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <!--
    modal: delete confirm
    -->
    <ModalWindow :visible="modalDeleteVisible" @close="modalDeleteVisible = false">
      <template v-slot:title>Confirm Removal</template>
      <slot>

        <p class="lead text-center">Confirm removing the following added diagnosis</p>
        <p class="text-center">{{ diffDiagnosisToEdit.disease.disease }}</p>

        <div class="text-center">
          <button class="btn btn-danger" @click="onDelete()">Remove</button>
        </div>

      </slot>
    </ModalWindow>
    <!--
    end: modal: delete confirm
    -->


  </div><!-- Template -->

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";
import {errorMessageBox} from "../../_common/bootbox_dialogs";

const _ = require('lodash');

export default {
  name: "DifferentialDiagnosis",
  components: {ModalWindow},


  data() {
    return {


      /* modal hooks */
      modalAddVisible: false,
      modalEditVisible: false,
      modalDeleteVisible: false,


      diffDiagnosisToAdd: {
        disease: "-1",
        remarks: "",
      },

      diffDiagnosisToEdit: {
        disease: {},
        remarks: ""
      },

    }
  },


  computed: {
    diffDiagnosisList: function () {
      return this.$store.getters.getDifferentialDiagnosisList;
    },

    diseasesList: function () {
      return this.$store.getters.getDiseasesList;
    },

    isEmpty: function () {
      return this.diffDiagnosisList.length === 0;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    }

  },


  async mounted() {

    try {

      await this.$store.dispatch("diffDiagnoses_fetchAllDiseases");
      await this.$store.dispatch("diffDiagnoses_fetchAll", this.visitId);

    } catch (e) {
      errorMessageBox("Failed to fetch differential diagnoses data");
    }

  },


  methods: {

    async fetchAllDiffDiagnoses() {
      try {
        await this.$store.dispatch("diffDiagnoses_fetchAll", this.visitId);
      } catch (e) {
        errorMessageBox("Failed to fetch diagnoses");
      }

    },


    /*
   * Add selected disease to diff. diagnosis
   * */
    async onAdd() {


      try {

        const params = {
          visit_id: this.visitId,
          disease_id: this.diffDiagnosisToAdd.disease.id,
          remarks: this.diffDiagnosisToAdd.remarks
        };

        await this.$store.dispatch("diffDiagnoses_add", params);
        this.modalAddVisible = false;

      } catch (e) {
        errorMessageBox("Failed to add diagnosis details");
      }

      await this.fetchAllDiffDiagnoses();


    },


    async onUpdate() {
      try {

        const params = {
          id: this.diffDiagnosisToEdit.id,
          remarks: this.diffDiagnosisToEdit.remarks
        }

        await this.$store.dispatch("diffDiagnoses_update", params);
        this.modalEditVisible = false;

      } catch (e) {
        errorMessageBox("Failed to update differential diagnosis");
      }

      await this.fetchAllDiffDiagnoses();

    },

    onShowDeleteConfirmModal(item) {

      this.diffDiagnosisToEdit = item;
      this.modalDeleteVisible = true;

    },

    async onDelete() {

      try {

        await this.$store.dispatch("diffDiagnoses_delete", this.diffDiagnosisToEdit.id);
        this.modalDeleteVisible = false;

      } catch (e) {
        errorMessageBox("Failed to delete differential diagnosis");
      }

      await this.fetchAllDiffDiagnoses();

    },


    onShowEditModal(item) {
      this.diffDiagnosisToEdit = _.cloneDeep(item);
      this.modalEditVisible = true;
    },

  },

}
</script>

<style scoped>

</style>
