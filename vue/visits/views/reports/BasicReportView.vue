<template>

  <div v-if="loaded">

    <div class="paper">
      <h4 class="mb-3 font-weight-bold report-heading">Dr Arulnithy's Clinic Report</h4>
      <PatientDetailsDiagnoses/>
    </div><!-- paper -->

    <div class="page-break"></div>

    <div class="paper">
      <PrescriptionDetails/>
    </div>

    <div class="position-absolute d-print-none" style="top: 5px; right: 10px">
      <button class="btn btn-primary" @click="openPrintDialog()">Print</button>
    </div>


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
    openPrintDialog() {
      window.print();
    }
  },

}
</script>

<style>


.paper {
  border: solid 1px #cccccc;
  box-shadow: 0 0 10px #cccccc;
  padding: 5mm;
  margin-bottom: 5mm;
}

.lead, .report-heading {
  margin-left: 10mm;
}


@media print {


  @page {
    size: A5;
    margin: 10mm 5mm;
  }

  @page :first {
    margin: 25mm 5mm;
  }


  .paper {
    font-size: 12pt !important;
    border: none;
    width: 200mm !important;
  }

  .lead {
    font-size: 14pt;
  }

  .page-break {
    clear: both;
    break-after: page;
  }

  .section {
    break-inside: avoid;
  }


  .page-footer:after {
    counter-increment: page;
    content: "Page " counter(page);
    position: absolute;
    right: 5mm;
    bottom: 5mm;
    white-space: nowrap;
    z-index: 20;
  }

}


</style>
