<template>

  <div v-if="loaded">

    <div class="paper">

      <div class="lead mb-3">Dr Arulnithy's Cardiac Clinic</div>

      <PatientDetailsDiagnoses/>
      <div class="page-break"></div>
      <PrescriptionDetails/>

    </div><!-- paper -->

  </div><!-- template -->

</template>

<script>
import PatientDetailsDiagnoses from "./basic_report_sections/PatientDetailsDiagnoses";
import PrescriptionDetails from "./basic_report_sections/PrescriptionDetails";

export default {
  name: "BasicReportView",
  components: {PrescriptionDetails, PatientDetailsDiagnoses},
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

    loaded() {
      return this.patient !== undefined && this.visit !== undefined;
    },


  },


  async mounted() {


  },

  methods: {
    //
  },

}
</script>

<style scoped>


.paper {
  border: solid 1px #cccccc;
  box-shadow: 0 0 10px #cccccc;
  padding: 5mm;
}


@media print {

  body {
    margin: 15mm 5mm 10mm 5mm;
  }

  @page {
    size: A5;
    margin: 15mm 5mm 10mm 5mm;
  }


  .paper {
    font-size: 12pt !important;
    border: none;
    width: 200mm !important;
  }

  .lead {
    font-size: 14pt;
    page-break-after: avoid;
  }

  .page-break {
    clear: both;
    page-break-after: always;
  }


}


</style>
