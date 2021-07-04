<template>

  <div v-if="loaded">

    <div class="paper">
      <PatientDetailsDiagnoses class="section"/>

      <PrescriptionDetails class="section"/>
    </div><!-- paper -->


    <div class="d-print-none text-center">
      <button class="btn btn-success" @click="openPrintDialog()">
        <img src="/assets/images/actions/print.svg" class="icon-24" alt=""> Print
      </button>
      <router-link class="btn btn-secondary" to="/reports">
        <img src="/assets/images/actions/back.svg" class="icon-24" alt=""> Back
      </router-link>
    </div>


  </div><!-- template -->

</template>

<script>
import PatientDetailsDiagnoses from "./basic_report_sections/PatientDetailsDiagnoses";
import PrescriptionDetails from "./basic_report_sections/PrescriptionDetails";

export default {
  name: "BasicReportView",
  components: { PrescriptionDetails, PatientDetailsDiagnoses },
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

<style scoped lang="scss">


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
    font-size: 14pt !important;
    border: none;
    /*width: 200mm !important;*/
  }

  .lead {
    font-size: 16pt;
  }

  .page-break {
    clear: both;
    break-after: page;
  }

  .section {
    break-inside: avoid;
  }

}


</style>


<style lang="scss">

/* This styles are universal for printing */

.paper {

  .border, table, tr, td, th {
    border: solid 1px black !important;
  }

  hr {
    border-top: solid 1px black !important;
  }

}

.prescription-details {

  figure {
    //margin: 0;
    text-align: center;
    display: block;
    margin-left: auto;
    margin-right: auto;
  }

  figure img {
    width: 100% !important;
    display: inline-block;
  }

}

</style>
