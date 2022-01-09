<template>

  <div v-if="loaded">


    <vue-html2pdf
        :show-layout="true"
        :float-layout="false"
        :enable-download="false"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        filename="basic-report"
        :pdf-quality="2"
        :manual-pagination="true"
        pdf-format="a5"
        pdf-orientation="portrait"
        pdf-content-width="100%"
        ref="html2Pdf"
        :html-to-pdf-options="htmlToPdfOptions"
    >
      <section slot="pdf-content">

        <div class="paper">

          <SectionEMSHeader :is-visible="isEmsHeaderVisible"/>

          <!-- patient details diagnoses -->
          <PatientDetailsDiagnoses/>

        </div><!-- paper -->

      </section>
    </vue-html2pdf>


    <div class="d-print-none text-center">

      <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="chk_ems_header" v-model="isEmsHeaderVisible">
          <label class="form-check-label" for="chk_ems_header">
            Show EMS Hospital Header
          </label>
        </div>
      </div>

      <button class="btn btn-success" @click="generateReport()">
        <img src="/assets/images/actions/print.svg" class="icon-24" alt=""> Print
      </button>
      <router-link class="btn btn-secondary" to="/reports">
        <img src="/assets/images/actions/back.svg" class="icon-24" alt=""> Back
      </router-link>
    </div>


  </div><!-- template -->

</template>

<script>
import VueHtml2pdf from 'vue-html2pdf';
import PatientDetailsDiagnoses from './basic_report_sections/PatientDetailsDiagnoses';
import PrescriptionDetails from './basic_report_sections/PrescriptionDetails';
import SectionEMSHeader from '@/visits/views/reports/components/SectionEMSHeader';

export default {
  name: 'BasicReportView',
  components: {SectionEMSHeader, PrescriptionDetails, PatientDetailsDiagnoses, VueHtml2pdf},
  data() {
    return {
      isEmsHeaderVisible: false,

      htmlToPdfOptions: {
        margin: [5.5, 0.5, 0.5, 0.5],

        filename: `basic-report.pdf`,

        image: {
          type: 'jpeg',
          quality: 1,
        },

        enableLinks: false,

        html2canvas: {
          scale: 3,
          useCORS: true,
          letterRendering: true
        },

        jsPDF: {
          unit: 'cm',
          format: 'a5',
          orientation: 'portrait',
        },
      },

    };
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
    },


    generateReport() {
      this.$refs.html2Pdf.generatePdf();
    },

  },

};
</script>

<style lang="scss" scoped>


</style>
