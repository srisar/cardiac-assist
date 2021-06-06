<template>

  <div>

    <div class="card shadow shadow-sm mb-3">

      <div class="card-header d-flex justify-content-between">
        <div>Prescriptions</div>
        <div>
          <button class="btn btn-tiny btn-success" @click="isAddPrescriptionModalVisible=true">Add</button>
        </div>
      </div><!-- card-header -->

      <div class="card-body">

        <table class="table table-sm table-bordered mb-5">
          <thead>
          <tr>
            <th>Remarks</th>
            <th class="text-center" style="width: 30px">Actions</th>
          </tr>
          </thead>
          <tbody>

          <tr v-for="item in prescriptionsList" :key="item.id">
            <td>{{ item.remarks }}</td>
            <td class="text-center">
              <router-link class="btn btn-tiny btn-secondary" :to="generateEditPrescriptionLink(item)">Open</router-link>
            </td>
          </tr>

          </tbody>
        </table>


      </div><!-- card-body -->

    </div><!-- card -->

    <!-- --------------------------------------------------------------------------------------------------- -->


    <!-- --------------------------------------------------------------------------------------------------- -->

    <!-- modal: add prescription -->
    <ModalWindow :visible="isAddPrescriptionModalVisible" @close="isAddPrescriptionModalVisible = false">
      <template v-slot:title>Add a prescription</template>

      <slot>

        <div class="row">
          <div class="col-4">

            <div class="form-group">
              <label>Date</label>
              <DateField v-model="prescriptionToAdd.date"/>
            </div>

          </div>
        </div>

        <div class="form-group">
          <label for="text-remarks" class="form-label">Remarks</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model="prescriptionToAdd.remarks"></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onAddNewPrescription()">Add</button>
        </div>

      </slot>
    </ModalWindow>
    <!-- end: modal add prescription -->


  </div><!-- template -->

</template>

<script>
import ModalWindow from "../../../../_common/components/ModalWindow";
import {errorMessageBox} from "../../../../_common/bootbox_dialogs";
import DateField from "../../../../_common/components/DateField";

export default {
  name: "PrescriptionView",
  components: {DateField, ModalWindow},
  data() {
    return {

      isAddPrescriptionModalVisible: false,
      /*
      * add prescription window
      * */
      prescriptionToAdd: {
        remarks: "",
        date: moment().format("YYYY-MM-DD"),
      },


      selectedPrescription: {},


    }
  },

  computed: {

    prescriptionsList() {
      return this.$store.getters.getVisitPrescriptions;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },
  },

  async mounted() {


    try {

      await this.$store.dispatch("prescriptions_fetchAll", this.visitId);

    } catch (e) {
      alert("Failed to fetch prescriptions");
    }

  },

  methods: {

    /*
    * Generate edit prescription link
    * */
    generateEditPrescriptionLink(prescription) {
      return `/prescription/edit/${prescription.id}`;
    },


    /*
    * On add new prescription
    * */
    async onAddNewPrescription() {

      try {

        const params = {
          visit_id: this.visitId,
          date: this.prescriptionToAdd.date,
          remarks: this.prescriptionToAdd.remarks,
        };

        await this.$store.dispatch("prescription_add", params);
        await this.$store.dispatch("prescriptions_fetchAll", this.visitId);

      } catch (e) {
        errorMessageBox("Failed to add new prescription");
      }

    }


  },
}
</script>

<style scoped>

</style>
