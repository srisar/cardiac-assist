<template>

  <div>

    <!-- start: edit prescription -->
    <div class="card shadow shadow-sm mb-3">
      <div class="card-header d-flex justify-content-between">
        <div>Prescription details</div>
        <div>
          <router-link to="/prescriptions" class="btn btn-tiny btn-secondary">Close</router-link>
        </div>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-2">
            <div class="form-group">
              <label>Date</label>
              <DateField v-model="selectedPrescription.date"/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Remarks</label>
          <textarea rows="3" class="form-control" v-model="selectedPrescription.remarks"></textarea>
        </div>


        <div class="d-flex justify-content-between mb-3">
          <button class="btn btn-sm btn-primary" @click="isAddDrugModalVisible = true">Add drugs...</button>
          <button class="btn btn-sm btn-success" @click="onUpdatePrescription()">Save</button>
        </div>


        <table class="table table-bordered table-sm">
          <thead>
          <tr>
            <th>Drug</th>
            <th>Dose</th>
            <th>Frequency</th>
            <th>Duration</th>
            <th>Remarks</th>
          </tr>
          </thead>

          <tbody>
          <tr v-for="item in selectedPrescription.prescription_items" :key="item.id">
            <td class="clickable-td" @click="onOpenEditPrescriptionItem(item)">{{ item.drug.drug_name }}</td>
            <td>{{ item.dose }}</td>
            <td>{{ item.frequency }}</td>
            <td>{{ item.duration }}</td>
            <td>{{ item.remarks }}</td>
          </tr>
          </tbody>

        </table>

        <div class="my-3">
          <AlertArea :feedback="feedback" @clear="feedback.message=''"/>
        </div>

      </div><!-- card-body -->

    </div><!-- card -->

    <div class="row mt-3">
      <div class="col">

        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="chk-confirm-delete" v-model="chkConfirmDeletePrescription">
          <label for="chk-confirm-delete">Delete this prescription</label>
        </div>

      </div>
    </div>

    <div class="alert alert-danger" v-if="chkConfirmDeletePrescription">
      <h5 class="text-center">Confirm deleting the prescription</h5>
      <p>Deleting the prescription is undoable operation. All associated items such as drug details associated with this prescription will be lost.</p>

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
          <input type="text" class="form-control" placeholder="search for drugs..." v-model="drugSearchQuery">
          <div class="input-group-append">
            <button class="btn btn-success" @click="onSearchDrugs()">Search</button>
          </div>
        </div>

        <hr>

        <table class="table table-bordered table-sm" v-if="drugsSearchResult.length > 0">
          <thead>
          <tr>
            <th style="width: 30px"></th>
            <th>Drug</th>
            <th>Remarks</th>
          </tr>
          </thead>

          <tbody>
          <tr v-for="item in drugsSearchResult" :key="item.id">
            <td class="clickable-td">
              <button class="btn btn-tiny btn-primary" @click="onAddToPrescription(item)">Add</button>
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


    <!-- modal: edit drug -->
    <ModalWindow :visible="isEditPrescriptionItemModalVisible" @close="isEditPrescriptionItemModalVisible = false">
      <template v-slot:title>Editing {{ selectedPrescriptionItem.drug_name }}</template>
      <slot>

        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Drug</label>
              <input type="text" class="form-control" :value="selectedPrescriptionItem.drug_name" readonly>
            </div>

          </div>
        </div>

        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Dose</label>
              <input type="text" class="form-control" v-model="selectedPrescriptionItem.dose">
            </div>


          </div>
          <div class="col">

            <div class="form-group">
              <label>Frequency</label>
              <input type="text" class="form-control" v-model="selectedPrescriptionItem.frequency">
            </div>

          </div>
          <div class="col">

            <div class="form-group">
              <label>Duration</label>
              <input type="text" class="form-control" v-model="selectedPrescriptionItem.duration">
            </div>

          </div>
        </div>

        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="3" class="form-control" v-model="selectedPrescriptionItem.remarks"></textarea>
            </div>

          </div>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onUpdatePrescriptionItem()">Update</button>
        </div>


      </slot>
    </ModalWindow>
    <!-- end: modal: edit drug -->


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
  components: {AlertArea, DateField, ModalWindow},

  data() {
    return {

      isAddDrugModalVisible: false,

      selectedPrescription: {
        id: undefined,
        visit_id: undefined,
        remarks: "",
        date: moment().format("YYYY-MM-DD"),
        prescription_items: [],
      },


      drugSearchQuery: "",
      drugsSearchResult: [],


      /* -- edit selected prescription item -- */
      isEditPrescriptionItemModalVisible: false,

      selectedPrescriptionItem: {
        id: undefined,
        prescription_id: undefined,
        drug_id: undefined,
        drug_name: undefined,
        dose: undefined,
        frequency: undefined,
        duration: undefined,
        remarks: undefined,
      },

      /* delete prescription */
      chkConfirmDeletePrescription: false,

      /* feedback */
      feedback: {
        message: "",
        type: TYPE_SUCCESS
      }
    }
  },


  computed: {

    prescriptionId() {
      return this.$route.params.id;
    }

  },


  async mounted() {

    try {


      await this.$store.dispatch("prescriptions_fetch", this.prescriptionId);
      this.selectedPrescription = this.$store.getters.getSelectedPrescription;

    } catch (e) {
      console.log(e);
      await this.$router.push("/prescriptions");
    }

  },


  methods: {

    /**
     * On search for drugs
     */
    async onSearchDrugs() {

      try {

        await this.$store.dispatch("prescriptions_searchDrugs", this.drugSearchQuery);
        this.drugsSearchResult = this.$store.getters.getDrugsSearchResult;

      } catch (e) {
        console.log(e);
      }
    },


    /*
    * On selecting a drug to add to prescription
    * */
    async onAddToPrescription(drug) {

      try {

        const params = {
          prescription_id: this.selectedPrescription.id,
          drug_id: drug.id,
          dose: "",
          frequency: "",
          duration: "",
          remarks: ""
        };

        await this.$store.dispatch("prescriptions_addPrescriptionItem", params);

        /* fetch updated prescription details */
        await this.$store.dispatch("prescriptions_fetch", this.prescriptionId);
        this.selectedPrescription = this.$store.getters.getSelectedPrescription;


      } catch (e) {
        alert("Failed to insert selected drug");
      }

    },


    /*
    * On open modal for editing selected drug
    * */
    onOpenEditPrescriptionItem(item) {

      this.selectedPrescriptionItem = {
        id: item.id,
        drug_id: item.drug_id,
        drug_name: item.drug.drug_name,
        dose: item.dose,
        frequency: item.frequency,
        duration: item.duration,
        remarks: item.remarks,
      }

      this.isEditPrescriptionItemModalVisible = true;

    },

    /*
    * On update prescription item
    * */
    async onUpdatePrescriptionItem() {

      try {

        const params = {
          id: this.selectedPrescriptionItem.id,
          dose: this.selectedPrescriptionItem.dose,
          frequency: this.selectedPrescriptionItem.frequency,
          duration: this.selectedPrescriptionItem.duration,
          remarks: this.selectedPrescriptionItem.remarks,
        }

        await this.$store.dispatch("prescriptions_updatePrescriptionItem", params);

        /* fetch updated prescription details */
        await this.$store.dispatch("prescriptions_fetch", this.prescriptionId);
        this.selectedPrescription = this.$store.getters.getSelectedPrescription;

        this.isEditPrescriptionItemModalVisible = false;

      } catch (e) {
        alert("Failed to update");
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
          remarks: this.selectedPrescription.remarks
        };

        await this.$store.dispatch("prescriptions_update", params);

        this.feedback.message = "Details updated successfully";

      } catch (e) {
        alert("Failed to update prescription details");
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

        await this.$store.dispatch("prescriptions_delete", params);

        await this.$router.push("/prescriptions");

      } catch (e) {
        errorMessageBox("Failed to delete the prescription");
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
