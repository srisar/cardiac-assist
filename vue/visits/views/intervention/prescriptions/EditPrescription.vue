<template>

  <div>

    <!-- start: edit prescription -->

    <div v-if="isLoading" class="text-center font-weight-bold">Fetching selected prescription details</div>

    <div class="card shadow shadow-sm mb-3" v-else>
      <div class="card-header d-flex justify-content-between">
        <div>Prescription details</div>
        <div>
          <router-link to="/prescriptions" class="btn btn-tiny btn-secondary">Close</router-link>
        </div>
      </div>

      <div class="card-body">

        <div class="row mb-3">
          <div class="col-3">
            <div class="input-group">
              <div class="input-group-prepend"><span class="input-group-text">Date</span></div>
              <DateField v-model="selectedPrescription.date"/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <textarea rows="2" class="form-control" v-model="selectedPrescription.remarks" placeholder="Add a remark about the prescription..."></textarea>
        </div>


        <div class="d-flex justify-content-between mb-3">
          <button class="btn btn-sm btn-primary" @click="isAddDrugModalVisible = true">Add drugs...</button>
          <button class="btn btn-sm btn-success" @click="onUpdatePrescription()">Save</button>
        </div>


        <table class="table table-bordered table-sm">
          <thead>
          <tr>
            <th class="" style="width: 20%">Drug</th>
            <th class="text-right" style="width: 100px">Dose</th>
            <th class="text-right" style="width: 130px">Frequency</th>
            <th class="text-right" style="width: 100px">Duration</th>
            <th class="text-right">Remarks</th>
          </tr>
          </thead>

          <tbody>
          <tr v-for="item in selectedPrescription.prescription_items" :key="item.id"
              @mouseover="showDeleteItemById = item.id" @mouseout="showDeleteItemById = null">

            <td class="align-middle">
              <button class="btn btn-tiny btn-outline-danger" @click="onDeletePrescriptionItem(item)" v-show="showDeleteItemById === item.id">
                <img src="/assets/images/actions/remove.svg" class="icon-16" alt="">
              </button>
              {{ item.drug.drug_name }}
            </td>

            <td class="text-right">
              <input type="text" class="form-control form-control-sm text-right" v-model.trim="item.dose">
            </td>
            <td class="text-right">
              <input type="text" class="form-control form-control-sm text-right" v-model.trim="item.frequency">
            </td>
            <td class="text-right">
              <input type="text" class="form-control form-control-sm text-right" v-model.trim="item.duration">
            </td>
            <td class="text-right">
              <input type="text" class="form-control form-control-sm" v-model.trim="item.remarks">
            </td>
          </tr>
          </tbody>

        </table>

        <div class="my-3">
          <AlertArea :feedback="feedback" @clear="feedback.message=''"/>
        </div>

      </div><!-- card-body -->

    </div><!-- card -->


    <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <!-- delete selected prescription -->

    <div class="row mt-3">
      <div class="col">

        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="chk-confirm-delete" v-model="chkConfirmDeletePrescription">
          <label for="chk-confirm-delete">Delete this prescription</label>
        </div>

      </div>
    </div>

    <div class="alert alert-danger text-center" v-if="chkConfirmDeletePrescription">
      <h5 class="text-center">Confirm deleting the prescription</h5>
      <p>All associated items such as drug details associated with this prescription will be lost.</p>

      <div class="text-center">
        <button class="btn btn-danger" @click="onDeletePrescription()">Delete</button>
      </div>

    </div>

    <!-- end: edit prescription -->


    <!-- modal: add prescription drug -->
    <ModalWindow :visible="isAddDrugModalVisible" @close="isAddDrugModalVisible = false">
      <template v-slot:title>Add a drug</template>

      <slot>


        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="search for drugs..." v-model="drugSearchQuery" @keyup.enter="onSearchDrugs()">
          <div class="input-group-append">
            <button class="btn btn-success" @click="onSearchDrugs()">Search</button>
          </div>
        </div>

        <hr>

        <table class="table table-bordered table-sm" v-if="drugsSearchResult.length > 0">
          <thead>
          <tr>
            <th style="width: 65px"></th>
            <th>Drug</th>
            <th>Remarks</th>
          </tr>
          </thead>

          <tbody>
          <tr v-for="item in drugsSearchResult" :key="item.id">
            <td>
              <button class="btn btn-tiny btn-outline-dark" @click="onAddToPrescription(item)">
                <img src="/assets/images/actions/add.svg" class="icon-16" alt="">
                Add
              </button>
            </td>
            <td>{{ item.drug_name }}</td>
            <td>{{ item.remarks }}</td>
          </tr>
          </tbody>

        </table>

        <div v-else>
          <p class="text-center">No results</p>
        </div>


      </slot>

    </ModalWindow>
    <!-- emd: modal: prescription drug -->


  </div>

</template>

<script>
import ModalWindow from "../../../../_common/components/ModalWindow";
import DateField from "../../../../_common/components/DateField";
import {errorMessageBox, successMessageBox} from "../../../../_common/bootbox_dialogs";
import AlertArea from "../../../../_common/components/AlertArea";
import {TYPE_SUCCESS} from "../../../../_common/message_types";

export default {
  name: "EditPrescription",
  components: { AlertArea, DateField, ModalWindow },

  data() {
    return {

      /* prescription id from route */
      prescriptionId: undefined,
      isLoading: true,


      isAddDrugModalVisible: false,


      selectedPrescription: {
        id: undefined,
        visit_id: undefined,
        remarks: "",
        date: moment().format( "YYYY-MM-DD" ),
        prescription_items: [],
      },


      drugSearchQuery: "",
      drugsSearchResult: [],


      /* delete prescription */
      chkConfirmDeletePrescription: false,

      /* feedback */
      feedback: {
        message: "",
        type: TYPE_SUCCESS
      },


      showDeleteItemById: null

    };

  },


  computed: {},


  async mounted() {

    try {

      this.isLoading = true;

      this.prescriptionId = this.$route.params.id;

      await this.$store.dispatch( "prescriptions_fetch", this.prescriptionId );
      this.selectedPrescription = this.$store.getters.getSelectedPrescription;

      this.isLoading = false;

    } catch ( e ) {
      await this.$router.push( "/prescriptions" );
    }

  },

  async beforeRouteUpdate( to, from, next ) {

    try {

      this.isLoading = true;

      this.prescriptionId = to.params.id;

      await this.$store.dispatch( "prescriptions_fetch", this.prescriptionId );
      this.selectedPrescription = this.$store.getters.getSelectedPrescription;

      this.isLoading = false;
      next();

    } catch ( e ) {
      await this.$router.push( "/prescriptions" );
    }

  },

  methods: {

    /**
     * On search for drugs
     */
    async onSearchDrugs() {

      try {

        await this.$store.dispatch( "prescriptions_searchDrugs", this.drugSearchQuery );
        this.drugsSearchResult = this.$store.getters.getDrugsSearchResult;

      } catch ( e ) {
        console.log( e );
      }
    },


    /*
    * On selecting a drug to add to prescription
    * */
    async onAddToPrescription( drug ) {

      try {

        const params = {
          prescription_id: this.selectedPrescription.id,
          drug_id: drug.id,
          dose: "",
          frequency: "",
          duration: "",
          remarks: ""
        };

        await this.$store.dispatch( "prescriptions_addPrescriptionItem", params );

        /* fetch updated prescription details */
        await this.$store.dispatch( "prescriptions_fetch", this.prescriptionId );
        this.selectedPrescription = this.$store.getters.getSelectedPrescription;


      } catch ( e ) {
        alert( "Failed to insert selected drug" );
      }

    },

    /*
    * On update prescription details
    * */
    async onUpdatePrescription() {

      try {

        const params = {
          id: this.selectedPrescription.id,
          date: this.selectedPrescription.date,
          remarks: this.selectedPrescription.remarks,
          prescription_items: this.selectedPrescription.prescription_items
        };

        // console.log(params);

        await this.$store.dispatch( "prescriptions_update", params );

        successMessageBox( "Prescription details updated" );

      } catch ( e ) {
        alert( "Failed to update prescription details" );
      }

    },

    /*
    * On delete prescription
    * */
    async onDeletePrescription() {

      try {

        const params = {
          id: this.selectedPrescription.id,
        };

        await this.$store.dispatch( "prescriptions_delete", params );

        await this.$router.push( "/prescriptions" );

      } catch ( e ) {
        errorMessageBox( "Failed to delete the prescription" );
      }

    },

    /*
    * On delete prescription item
    * */
    async onDeletePrescriptionItem( prescription ) {

      try {

        const params = {
          id: prescription.id,
        };

        await this.$store.dispatch( "prescriptions_deletePrescriptionItem", params );

        /* fetch updated prescription details */
        await this.$store.dispatch( "prescriptions_fetch", this.prescriptionId );
        this.selectedPrescription = this.$store.getters.getSelectedPrescription;

        this.isEditPrescriptionItemModalVisible = false;

      } catch ( e ) {
        errorMessageBox( "Failed to delete prescription item" );
      }

    }


  },

}
</script>

<style scoped>

.clickable-td:hover {
  cursor: pointer;
  background-color: #0a90eb;
  color: #FFFFFF;
}

</style>
