<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Differential Diagnoses</div>
      </div><!-- card-header -->

      <div class="card-body" v-if="loaded">

        <div class="mb-3">
          <button class="btn btn-sm btn-outline-success" @click="modalAddVisible = true">
            <img src="/assets/images/actions/add.svg" alt="" class="icon-16"> Add
          </button>
        </div>


        <table class="table table-sm table-hover table-bordered" v-if="!isEmpty">

          <tbody>
          <tr v-for="item in diffDiagnosisList" :key="item.id"
              @mouseover="showHoverItemsById = item.id" @mouseout="showHoverItemsById = null">


            <td class="position-relative">

              <p class="font-weight-bold"><a href="#">{{ item.disease.disease }}</a> ({{ item.disease.disease_code }})</p>
              <div style="white-space: pre-line">{{ item.remarks }}</div>


              <div class="mt-2 position-absolute hover-group p-1 rounded" v-show="showHoverItemsById === item.id">
                <button class="btn btn-tiny btn-outline-dark" @click="onShowEditModal(item)">
                  <img src="/assets/images/actions/edit.svg" class="icon-16" alt="">
                </button>

                <button class="btn btn-tiny btn-outline-danger" @click="onShowDeleteConfirmModal(item)">
                  <img src="/assets/images/actions/remove.svg" alt="" class="icon-16">
                </button>

              </div>

            </td>

          </tr>
          </tbody>
        </table>

        <div v-else>
          <p>No items. Start adding some differential diagnoses</p>
        </div>

      </div><!-- card-body -->

      <div v-else class="card-body">
        <TheLoading/>
      </div>

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

import ModalWindow from "../../../_common/components/ModalWindow";
import {errorMessageBox} from "../../../_common/bootbox_dialogs";
import TheLoading from "../../../_common/components/TheLoading";

const _ = require( 'lodash' );

export default {
  name: "DifferentialDiagnosis",
  components: { TheLoading, ModalWindow },


  data() {
    return {

      loaded: false,

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

      showHoverItemsById: null,

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

      await this.$store.dispatch( "diffDiagnoses_fetchAllDiseases" );
      await this.$store.dispatch( "diffDiagnoses_fetchAll", this.visitId );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch differential diagnoses data" );
    }

  },


  methods: {

    async fetchAllDiffDiagnoses() {
      try {
        await this.$store.dispatch( "diffDiagnoses_fetchAll", this.visitId );
      } catch ( e ) {
        errorMessageBox( "Failed to fetch diagnoses" );
      }

    },


    /* On add */
    async onAdd() {


      try {

        const params = {
          visit_id: this.visitId,
          disease_id: this.diffDiagnosisToAdd.disease.id,
          remarks: this.diffDiagnosisToAdd.remarks
        };

        await this.$store.dispatch( "diffDiagnoses_add", params );
        this.modalAddVisible = false;

      } catch ( e ) {
        errorMessageBox( "Failed to add diagnosis details" );
      }

      await this.fetchAllDiffDiagnoses();


    },


    /* On update */
    async onUpdate() {
      try {

        const params = {
          id: this.diffDiagnosisToEdit.id,
          remarks: this.diffDiagnosisToEdit.remarks
        }

        await this.$store.dispatch( "diffDiagnoses_update", params );
        this.modalEditVisible = false;

      } catch ( e ) {
        errorMessageBox( "Failed to update differential diagnosis" );
      }

      await this.fetchAllDiffDiagnoses();

    },


    /* On delete */
    async onDelete() {

      try {

        await this.$store.dispatch( "diffDiagnoses_delete", this.diffDiagnosisToEdit.id );
        this.modalDeleteVisible = false;

      } catch ( e ) {
        errorMessageBox( "Failed to delete differential diagnosis" );
      }

      await this.fetchAllDiffDiagnoses();

    },


    onShowEditModal( item ) {
      this.diffDiagnosisToEdit = _.cloneDeep( item );
      this.modalEditVisible = true;
    },

    onShowDeleteConfirmModal( item ) {

      this.diffDiagnosisToEdit = item;
      this.modalDeleteVisible = true;
    },

  },

}
</script>

<style scoped>


</style>
