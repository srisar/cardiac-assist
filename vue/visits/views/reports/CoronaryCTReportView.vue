<template>

  <div>

    <div class="paper">
      <PatientBasicDetails/>

      <div class="section-coronary-ct">

        <h3 class="text-center">Coronary CT Report</h3>

        <table class="table table-bordered">
          <tbody>

          <tr>
            <td colspan="2">
              <div class="font-weight-bold">Total calcium score</div>
              <div>{{ visitCoronaryCT.total_calcium_score }}</div>
            </td>
          </tr>

          <tr>
            <td style="width: 50%">
              <div class="font-weight-bold">Origin</div>
              <div>{{ visitCoronaryCT.origin }}</div>
            </td>
            <td>
              <div class="font-weight-bold">Dominance</div>
              <div>{{ visitCoronaryCT.dominance }}</div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold">Left Main</div>
              <div>{{ visitCoronaryCT.left_main }}</div>
            </td>
            <td>
              <div class="font-weight-bold">LAD</div>
              <div>{{ visitCoronaryCT.lad }}</div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold">LCX</div>
              <div>{{ visitCoronaryCT.lcx }}</div>
            </td>
            <td>
              <div class="font-weight-bold">Cardiac Valves</div>
              <div>{{ visitCoronaryCT.cardiac_valves }}</div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold">Pericardium</div>
              <div>{{ visitCoronaryCT.pericardium }}</div>
            </td>
            <td>
              <div class="font-weight-bold">Extra Cardiac Findings</div>
              <div>{{ visitCoronaryCT.extra_cardiac_findings }}</div>
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <div class="font-weight-bold">Impression</div>
              <div>{{ visitCoronaryCT.impression }}</div>
            </td>
          </tr>

          </tbody>
        </table>

      </div>

    </div><!-- paper -->

    <div class="d-print-none text-center">
      <button class="btn btn-success" @click="openPrintDialog()">
        <img src="/assets/images/actions/print.svg" class="icon-24" alt=""> Print
      </button>
      <router-link class="btn btn-secondary" to="/reports">
        <img src="/assets/images/actions/back.svg" class="icon-24" alt=""> Back
      </router-link>
    </div>

  </div>

</template>

<script>
import {errorMessageBox} from "../../../_common/bootbox_dialogs";
import PatientDetailsDiagnoses from "./basic_report_sections/PatientDetailsDiagnoses";
import PatientBasicDetails from "./basic_report_sections/PatientBasicDetails";

export default {
  name: "CoronaryCTReportView",
  components: { PatientBasicDetails, PatientDetailsDiagnoses },
  data() {
    return {
      visitCoronaryCT: {
        id: null,
        visit_id: null,
        total_calcium_score: null,
        origin: null,
        dominance: null,
        left_main: null,
        lad: null,
        lcx: null,
        cardiac_valves: null,
        pericardium: null,
        extra_cardiac_findings: null,
        impression: null,
      },
    }
  },


  computed: {
    //
  },

  async mounted() {
    try {

      const id = this.$store.getters.getVisitId;
      const params = {
        visit_id: id,
      };

      const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-coronary-ct.php`, params );
      this.visitCoronaryCT = response.data;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch coronary ct details" );
    }
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

@media print {


  @page {
    size: A4;
    margin: 20mm 10mm;
  }

  .paper {
    font-size: 14pt !important;
    border: none;
    /*width: 200mm !important;*/
  }
}
</style>
