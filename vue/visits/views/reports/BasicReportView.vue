<template>

  <div v-if="loaded">

    <div class="paper">

      <div class="ems-header mb-3" v-if="isEmsHeaderVisible">
        <div class="d-flex align-items-center">
          <div class="mr-3">
            <img src="/assets/images/ems-logo.png" style="width: 100px" alt="">
          </div>

          <div>
            <div class="font-weight-bold">No.121, New Kalmunai Road</div>
            <div class="font-weight-bold">Kallady, Batticaloa</div>
            <div class="">Phone: 065 222 8812, 065 222 8800</div>
            <div>Email: ems.hospital.batticaloa@gmail.com</div>
          </div>

        </div>
      </div>

      <PatientDetailsDiagnoses class="section"/>
      <PrescriptionDetails class="section"/>
    </div><!-- paper -->


    <div class="d-print-none text-center">

      <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="chk_ems_header" v-model="isEmsHeaderVisible">
          <label class="form-check-label" for="chk_ems_header">
            Show EMS Hospital Header
          </label>
        </div>
      </div>

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
      isEmsHeaderVisible: false,
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

<style lang="scss">

@media print {

  @page {
    size: A5 !important;
    margin: 5mm !important;
  }


  .paper {
    width: 200mm !important;
  }

}

</style>
