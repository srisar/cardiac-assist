<template>

  <div v-if="prescription">

    <!-- prescriptions -->
    <div class="lead text-center text-uppercase font-weight-bold">Prescriptions</div>

    <table class="table table-sm table-bordered">
      <tr>
        <td>Date: {{ prescription.date }}</td>
      </tr>
    </table>

    <!-- prescription items -->
    <table class="table table-bordered table-sm">
      <thead>
      <tr>
        <th>Drug</th>
        <th>Dose</th>
        <th>Frequency</th>
        <th>Duration</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in prescription.prescription_items" :key="item.id">
        <td>{{ item.drug.drug_name }}</td>
        <td>{{ item.dose }}</td>
        <td>{{ item.frequency }}</td>
        <td>{{ item.duration }}</td>
      </tr>
      </tbody>
    </table>

  </div>

</template>

<script>
import {errorMessageBox} from "../../../../_common/bootbox_dialogs";

export default {
  name: "PrescriptionDetails",
  data() {
    return {
      //
    }
  },

  computed: {
    visit() {
      return this.$store.getters.getVisit;
    },

    patient() {
      return this.$store.getters.getPatient;
    },

    prescription() {
      return this.$store.getters.getVisitPrescriptions[0];
    }

  },

  async mounted() {

    try {

      const visitId = this.$store.getters.getVisitId;

      await this.$store.dispatch("prescriptions_fetchAll", visitId);

    } catch (e) {
      errorMessageBox("Failed to fetch prescription details");
    }

  },

  methods: {
    //
  },

}
</script>

<style scoped>

</style>
