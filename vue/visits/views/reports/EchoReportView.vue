<template>

  <div id="report__echo" v-if="loaded">


    <vue-html2pdf
        :show-layout="true"
        :float-layout="false"
        :enable-download="false"
        :preview-modal="true"
        :paginate-elements-by-height="50"
        filename="hee hee"
        :pdf-quality="2"
        :manual-pagination="true"
        pdf-format="a4"
        pdf-orientation="portrait"
        pdf-content-width="755px"
        ref="html2Pdf"
        :html-to-pdf-options="htmlToPdfOptions"
    >
      <section slot="pdf-content">

        <div class="paper">

          <SectionEMSHeader :is-visible="isEmsHeaderVisible"/>

          <h4 class="text-center text-uppercase">Echocardiogram Report</h4>

          <!-- Patient basic details: Name and age -->
          <PatientBasicDetails :show-e-f="false" :show-extra="false"/>

          <div class="d-flex justify-content-end font-weight-bold" style="gap: 10px">
            <span>Performed by:</span>
            <span>{{ visit.performed_by }}</span>
          </div>

          <div class="mt-3 report-a4">

            <LeftVentricle :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <LeftAtrium :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <MitralValve :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <AorticValve :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <Aorta :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <RightVentricle :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <RightAtrium :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <PulmonicValve :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <Tricuspid :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <Pericardium :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
            <Conclusion :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>


          </div><!-- section-echo-report -->

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
import {errorMessageBox} from '@/_common/bootbox_dialogs';
import TheLoading from '@/_common/components/TheLoading';
import PatientBasicDetails from '@/visits/views/reports/basic_report_sections/PatientBasicDetails';
import LeftVentricle from '@/visits/views/reports/echo_report_sections/LeftVentricle.vue';
import VueHtml2pdf from 'vue-html2pdf';
import SectionEMSHeader from "@/visits/views/reports/components/SectionEMSHeader";
import LeftAtrium from "@/visits/views/reports/echo_report_sections/LeftAtrium";
import MitralValve from "@/visits/views/reports/echo_report_sections/MitralValve";
import AorticValve from "@/visits/views/reports/echo_report_sections/AorticValve";
import Aorta from "@/visits/views/reports/echo_report_sections/Aorta";
import RightVentricle from "@/visits/views/reports/echo_report_sections/RightVentricle";
import RightAtrium from "@/visits/views/reports/echo_report_sections/RightAtrium";
import PulmonicValve from "@/visits/views/reports/echo_report_sections/PulmonicValve";
import Tricuspid from "@/visits/views/reports/echo_report_sections/Tricuspid";
import Pericardium from "@/visits/views/reports/echo_report_sections/Pericardium";
import Conclusion from "@/visits/views/reports/echo_report_sections/Conclusion";

export default {
  name: 'EchoReportView',
  components: {
    Conclusion,
    Pericardium,
    Tricuspid,
    PulmonicValve,
    RightAtrium,
    RightVentricle,
    Aorta,
    AorticValve,
    MitralValve, LeftAtrium, SectionEMSHeader, LeftVentricle, TheLoading, PatientBasicDetails, VueHtml2pdf,
  },
  data() {
    return {
      loaded: false,
      isEmsHeaderVisible: true,

      htmlToPdfOptions: {
        margin: [0.2, 0.1, 0.2, 0.1],

        filename: `basic-report.pdf`,

        image: {
          type: 'jpeg',
          quality: 0.98,
        },

        enableLinks: false,

        html2canvas: {
          scale: 3,
          useCORS: true,
        },

        jsPDF: {
          unit: 'in',
          format: 'a4',
          orientation: 'portrait',
        },
      },

    };
  },

  computed: {

    visitEcho() {
      return this.$store.getters.getVisitEcho;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },

    visit() {
      return this.$store.getters.getVisit;
    },

    allEchoRemarks: function () {
      return this.$store.getters.getEchoRemarks;
    },

    visitEchoRemarks: function () {
      return this.$store.getters.getVisitEchoRemarks;
    },


    /*
    * ------------------------------------------------
    *
    * Used in left ventricle section
    *
    * -----------------------------------------------
    * */

    eOverA() {
      if (this.visitEcho.param_dd_a === 0) return 0;
      return (this.visitEcho.param_dd_e / this.visitEcho.param_dd_a).toFixed(2);
    },

    eOverEBar() {
      if (this.visitEcho.param_dd_e_bar === 0) return 0;
      return (this.visitEcho.param_dd_e / this.visitEcho.param_dd_e_bar).toFixed(2);
    },

    cardiacIndex() {
      if (this.visitEcho.param_cardiac_output === 0) return 0;
      return (this.visitEcho.param_cardiac_output / this.visitEcho.visit.bsa).toFixed(2);
    },


  },
  /* -- computed -- */


  async mounted() {
    try {

      await this.$store.dispatch('visitEcho_fetch', this.visitId);


    } catch (e) {
      errorMessageBox('Failed to fetch echo details');
    }

    /* fetch all echo remarks */
    try {

      await this.$store.dispatch('echo_fetchAllRemarks');
      await this.$store.dispatch('echo_fetchAllVisitRemarks', this.visitId);

      this.loaded = true;

    } catch (e) {
      errorMessageBox('Failed to fetch remarks');
    }
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

<style lang="scss">

.abbr {
  font-size: 12px;
}

@media print {

  #report__echo {

    h5 {
      font-size: 16pt;
    }

    .abbr {
      font-size: 12pt;
    }

  }

}

</style>
