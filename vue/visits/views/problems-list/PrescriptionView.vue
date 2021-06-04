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
            <th class="text-center">Actions</th>
          </tr>
          </thead>
          <tbody>

          <tr v-for="item in prescriptionsList" :key="item.id">
            <td>{{ item.remarks }}</td>
            <td class="text-center">
              <button class="btn btn-tiny btn-primary" @click="onOpenPrescription(item)">Open</button>
            </td>
          </tr>

          </tbody>
        </table>


        <!-- start: edit prescription -->

        <div class="card shadow shadow-sm mb-3" v-if="! isSelectedPrescriptionEmpty">
          <div class="card-header d-flex justify-content-between">
            <div>Selected prescription details</div>
            <div>
              <button class="btn btn-tiny btn-secondary" @click="selectedPrescription = {}">Close</button>
            </div>
          </div>

          <div class="card-body">

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="3" class="form-control" v-model="selectedPrescription.remarks"></textarea>
            </div>


            <div class="mb-3">
              <button class="btn btn-sm btn-primary" @click="isAddDrugModalVisible = true">Add a drug</button>
            </div>
            <table class="table table-bordered table-sm">
              <thead>
              <tr>
                <th>Drug</th>
                <th>Dose</th>
                <th>Frequency</th>
                <th>Duration</th>
                <th>Actions</th>
              </tr>
              </thead>

              <tbody>
              <tr>

              </tr>
              </tbody>

            </table>

          </div><!-- card-body -->

        </div><!-- card -->

        <!-- end: edit prescription -->


      </div><!-- card-body -->

    </div><!-- card -->

    <!-- --------------------------------------------------------------------------------------------------- -->


    <!-- --------------------------------------------------------------------------------------------------- -->

    <!-- modal: add prescription -->
    <ModalWindow :visible="isAddPrescriptionModalVisible" @close="isAddPrescriptionModalVisible = false">
      <template v-slot:title>Add a prescription</template>

      <slot>

        <div class="form-group">
          <label for="text-remarks" class="form-label">Remarks</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model="prescriptionToAdd.remarks"></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success">Add</button>
        </div>

      </slot>
    </ModalWindow>
    <!-- end: modal add prescription -->


    <!-- modal: add prescription drug -->
    <ModalWindow :visible="isAddDrugModalVisible" @close="isAddDrugModalVisible = false">
      <template v-slot:title>Add a drug</template>

      <slot>

      </slot>

    </ModalWindow>
    <!-- emd: modal: prescription drug -->
  </div><!-- template -->

</template>

<script>
import ModalWindow from "../../../_common/components/ModalWindow";

export default {
  name: "PrescriptionView",
  components: {ModalWindow},
  data() {
    return {

      isAddPrescriptionModalVisible: false,
      isAddDrugModalVisible: false,

      prescriptionToAdd: {
        remarks: ""
      },

      selectedPrescription: {},

    }
  },

  computed: {

    prescriptionsList() { return this.$store.getters.getVisitPrescriptions; },
    isSelectedPrescriptionEmpty() { return _.isEmpty(this.selectedPrescription); },

  },

  async mounted() {


    try {

      const visit_id = this.$store.getters.getVisitId;
      await this.$store.dispatch("prescriptions_fetchAll", visit_id);

    } catch (e) {
      alert("Failed to fetch prescriptions");
    }

  },

  methods: {

    onOpenPrescription(prescription) {
      this.selectedPrescription = prescription;
    },


  },
}
</script>

<style scoped>

</style>
