<template>

  <div>

    <div v-if="prescription">

      <!-- prescriptions -->
      <div class="lead text-uppercase font-weight-bold">Prescriptions</div>

      <table class="table table-sm table-bordered">
        <tr>
          <td class="font-weight-bold">{{ prescription.date }} | {{ prescription.remarks }}</td>
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

    <div v-if="!loaded">
      <TheLoading/>
    </div>


  </div>

</template>

<script>
import {errorMessageBox} from "../../../../_common/bootbox_dialogs";
import TheLoading from "../../../../_common/components/TheLoading";

export default {
  name: "PrescriptionDetails",
  components: { TheLoading },
  data() {
    return {
      loaded: false,
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
      return this.$store.getters.getVisitPrescriptions[ 0 ];
    }

  },

  async mounted() {

    try {

      const visitId = this.$store.getters.getVisitId;
      await this.$store.dispatch( "prescriptions_fetchAll", visitId );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch prescription details" );
    }

  },

  methods: {
    //
  },

}
</script>

<style scoped>

@media print {

  .paper {
    font-size: 14pt !important;
    border: none;
    /*width: 200mm !important;*/
  }


  .page-break {
    clear: both;
    break-after: page;
  }

  .section, table {
    break-inside: avoid;
  }

}

</style>
