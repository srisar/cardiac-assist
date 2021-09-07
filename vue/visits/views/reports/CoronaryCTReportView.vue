<template>

  <div>

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

      <h3 class="text-center">Coronary CT Report</h3>

      <PatientBasicDetails/>

      <div class="section-coronary-ct">

        <table class="table table-bordered">
          <tbody>

          <tr>
            <td colspan="2">
              <div class="font-weight-bold text-uppercase">Total calcium score</div>
              <div>{{ visitCoronaryCT.total_calcium_score }}</div>
            </td>
          </tr>

          <tr>
            <td style="width: 50%">
              <div class="font-weight-bold text-uppercase">Origin</div>
              <div>{{ visitCoronaryCT.origin }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-uppercase">Dominance</div>
              <div>{{ visitCoronaryCT.dominance }}</div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold text-uppercase">Left Main</div>
              <div>{{ visitCoronaryCT.left_main }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-uppercase">LAD</div>
              <div>{{ visitCoronaryCT.lad }}</div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold text-uppercase">LCX</div>
              <div>{{ visitCoronaryCT.lcx }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-uppercase">Cardiac Valves</div>
              <div>{{ visitCoronaryCT.cardiac_valves }}</div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold text-uppercase">Pericardium</div>
              <div>{{ visitCoronaryCT.pericardium }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-uppercase">Extra Cardiac Findings</div>
              <div>{{ visitCoronaryCT.extra_cardiac_findings }}</div>
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <div class="font-weight-bold text-uppercase">Impression</div>
              <div>{{ visitCoronaryCT.impression }}</div>
            </td>
          </tr>

          </tbody>
        </table>

      </div>

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

  </div>

</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs';
import PatientBasicDetails from './basic_report_sections/PatientBasicDetails';
import PatientDetailsDiagnoses from './basic_report_sections/PatientDetailsDiagnoses';

export default {
  name: 'CoronaryCTReportView',
  components: { PatientBasicDetails, PatientDetailsDiagnoses },
  data() {
    return {

      isEmsHeaderVisible: false,

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
    };
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
      errorMessageBox( 'Failed to fetch coronary ct details' );
    }
  },

  methods: {
    openPrintDialog() {
      window.print();
    },
  },

};
</script>

<style scoped lang="scss">


</style>
