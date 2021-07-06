<template>

  <div>

    <div class="paper">

      <h3 class="text-center">Echocardiogram Report</h3>

      <PatientBasicDetails/>

      <div class="section-echo-report" v-if="loaded">

        <!-- section:Left Ventricle -->

        <div class="border p-2 mb-3 section">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Left Ventricle</h5>
          </div>


          <table class="table table-sm table-bordered">
            <tbody>
            <tr>
              <td class="text-center">IVS (mm)</td>
              <td class="text-center">LVID D (mm)</td>
              <td class="text-center">PW (mm)</td>
              <td class="text-center">LVEF (%)</td>
              <td class="text-center">FS</td>
              <td class="text-center">LVID S (mmHg)</td>
            </tr>
            <tr>
              <td class="text-center font-weight-bold">{{ visitEcho.param_ivs_diastolic_thickness }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_lvid_diastole }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_pw_diastolic_thickness }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_lvef }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_fractional_shortening }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_lvid_systole }}</td>
            </tr>
            </tbody>
          </table>

          <div class="" v-if="visitEcho.has_diastolic_dysfunction">
            <div class="">
              <div class="font-weight-bold text-uppercase">Has diastolic dysfunction</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="">A: <span class="font-weight-bold">{{ visitEcho.param_dd_a }}</span></td>
                <td class="">E: <span class="font-weight-bold">{{ visitEcho.param_dd_e }}</span></td>
                <td class="">E': <span class="font-weight-bold">{{ visitEcho.param_dd_e_bar }}</span></td>
                <td class="">E/A: <span class="font-weight-bold">{{ eOverA }}</span></td>
                <td class="">E/E': <span class="font-weight-bold">{{ eOverEBar }}</span></td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEcho.show_advanced">
            <div class="">
              <div class="font-weight-bold text-uppercase">Advanced</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="text-center">Stroke Volume (ml)</td>
                <td class="text-center">Cardiac Output (l/min)</td>
                <td class="text-center">HR (beat/min)</td>
                <td class="text-center">BP (mmHg)</td>
                <td class="text-center">Cardiac Index (l/min/m²)</td>
              </tr>
              <tr>
                <td class="text-center font-weight-bold">{{ visitEcho.param_stroke_volume }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_cardiac_output }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_hr }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_bp }}</td>
                <td class="text-center font-weight-bold">{{ cardiacIndex }}</td>
              </tr>
            </table>

          </div>

          <div class="" v-if="visitEchoRemarks.LEFT_VENTRICLE.length > 0">
            <ol>
              <li v-for="item in visitEchoRemarks.LEFT_VENTRICLE">
                {{ item.value }}
              </li>
            </ol>
          </div>

        </div>
        <!-- section:Left Ventricle -->

        <!-- section: Left Atrium -->
        <div class="border p-2 mb-3 section">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Left Atrium</h5>
          </div>

          <div v-if="visitEcho.is_left_atrium_dilated">

            <div class="">
              <div class="font-weight-bold text-uppercase">Is dilated</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="w-50">LA Systolic Diameter (mm): <span class="font-weight-bold">{{ visitEcho.param_la_systolic_diameter }}</span></td>
                <td class="w-50">LA Area(mm²): <span class="font-weight-bold">{{ visitEcho.param_la_area }}</span></td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEcho.has_asd">

            <div class="">
              <div class="font-weight-bold text-uppercase">Has ASD</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="w-50">ASD Size (mm): <span class="font-weight-bold">{{ visitEcho.param_asd_size }}</span></td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEchoRemarks.LEFT_ATRIUM.length > 0">

            <ol>
              <li v-for="item in visitEchoRemarks.LEFT_ATRIUM">
                {{ item.value }}
              </li>
            </ol>
          </div>

        </div>
        <!-- section: Left Atrium -->

        <!-- section: mitral valve -->
        <div class="border p-2 mb-3 section" v-if="visitEcho.has_mitral_stenosis || visitEchoRemarks.MITRAL_VALVE.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Mitral Valve</h5>
          </div>

          <div class="" v-if="visitEcho.has_mitral_stenosis">

            <div class="">
              <div class="font-weight-bold text-uppercase">Has Mitral Stenosis</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="text-center">Mitral Pressure 1/2 T (mmHg)</td>
                <td class="text-center"> Mean Mitral Gradient (mmHg)</td>
                <td class="text-center">Doppler Mitral VA (mm²)</td>
                <td class="text-center">Trace Mitral VA (mm²)</td>
                <td class="text-center">MV Score</td>
              </tr>
              <tr>
                <td class="text-center font-weight-bold">{{ visitEcho.param_mitral_pressure }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_mean_mitral_gradient }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_doppler_mitral_valve_area }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_trace_mitral_valve_area }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_mv_score }}</td>
              </tr>
            </table>

          </div>

          <div class="" v-if="visitEchoRemarks.MITRAL_VALVE.length > 0">

            <ol>
              <li v-for="item in visitEchoRemarks.MITRAL_VALVE">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: mitral valve -->

        <!-- section: aortic valve -->
        <div class="section border p-2 mb-3">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Aortic Valve</h5>
          </div>


          <div class="" v-if="visitEcho.is_diseased_aortic_valve">

            <div class="">
              <div class="font-weight-bold">Diseased</div>
            </div>

            <div>VA = Valve Area, AV = Aortic Velocity, AG = Aortic Gradient, V = velocity</div>
            <table class="table table-sm table-bordered">
              <tr>
                <td class="text-center w-25">Peak AG (mmHg)</td>
                <td class="text-center w-25">Mean AG (mmHg)</td>
                <td class="text-center w-25">Aortic VA (mm²)</td>
                <td class="text-center w-25">Peak AV (cm/s)</td>
              </tr>
              <tr>
                <td class="text-center font-weight-bold">{{ visitEcho.param_peak_aortic_gradient }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_mean_aortic_gradient }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_aortic_valve_area }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_peak_aortic_velocity }}</td>
              </tr>
              <tr>
                <td class="text-center">Peak LVOT V (cm/s)</td>
                <td class="text-center">Aortic/LVOT V (cm/s)</td>
                <td class="text-center">ARPHT (mm)</td>
                <td class="text-center">LVOT Diameter (mm)</td>
              </tr>
              <tr>
                <td class="text-center font-weight-bold">{{ visitEcho.param_peak_lvot_velocity }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_aortic_lvot_velocity }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_arpht }}</td>
                <td class="text-center font-weight-bold">{{ visitEcho.param_lvot_diameter }}</td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEchoRemarks.AORTIC_VALVE.length > 0">

            <ol>
              <li v-for="item in visitEchoRemarks.AORTIC_VALVE">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: aortic valve -->

        <!-- section: aorta -->
        <div class="section border p-2 mb-3">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Aorta</h5>
          </div>

          <table class="table table-sm table-bordered">
            <tr>
              <td class="text-center">Root (mm)</td>
              <td class="text-center">Annulus (mm)</td>
              <td class="text-center">ST Junction (mm)</td>
              <td class="text-center">Proximal Aorta (mm)</td>
              <td class="text-center">Aortic Arch (mm)</td>
            </tr>
            <tr>
              <td class="text-center font-weight-bold">{{ visitEcho.param_aorta_root }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_aorta_annulus }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_aorta_st_junction }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_aorta_proximal }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_aorta_aortic_arch }}</td>
            </tr>
          </table>

          <div class="" v-if="visitEcho.is_diseased_aorta">
            <div class="">
              <div class="font-weight-bold text-uppercase">Diseased</div>
            </div>

            <table class="table table-bordered table-sm">
              <tr>
                <td>Aortic Root Diameter (mm): <span class="font-weight-bold">{{ visitEcho.param_aortic_root_diameter }}</span></td>
              </tr>
            </table>

          </div>

          <div class="" v-if="visitEchoRemarks.AORTA.length > 0">
            <ol>
              <li v-for="item in visitEchoRemarks.AORTA">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: aorta -->

        <!-- section: right-ventricle -->
        <div class="section border p-2 mb-3">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Right Ventricle / Pulmonary Artery</h5>
          </div>

          <div>TV = Tricuspid Velocity</div>
          <table class="table table-bordered table-sm">
            <tr>
              <td class="text-center w-25">TAPSE (mm)</td>
              <td class="text-center w-25">Peak TV (cm/s)</td>
              <td class="text-center w-25">Est. RVSP (mmHg)</td>
              <td class="text-center w-25">Est. CVP (mmHg)</td>

            </tr>
            <tr>
              <td class="text-center font-weight-bold">{{ visitEcho.param_tapse }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_peak_tricuspid_velocity }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_est_rvsp }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_est_cvp }}</td>

            </tr>
            <tr>
              <td class="text-center">Est. PASP (mmHg)</td>
              <td class="text-center"> Est. CVP (mmHg)</td>
              <td class="text-center">MPA (mm)</td>
              <td class="text-center">RVOT1 (mm)</td>

            </tr>
            <tr>
              <td class="text-center font-weight-bold">{{ visitEcho.param_est_pasp }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_est_cvp }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_mpa }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_rvot1 }}</td>

            </tr>
            <tr>
              <td class="text-center">RVOT2 (mm)</td>
              <td class="text-center">RVOTAT (mm)</td>
              <td class="text-center">RVID (mm)</td>
              <td></td>
            </tr>
            <tr>
              <td class="text-center font-weight-bold">{{ visitEcho.param_rvot2 }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_rvotat }}</td>
              <td class="text-center font-weight-bold">{{ visitEcho.param_rvid }}</td>
              <td></td>
            </tr>
          </table>


          <div class="" v-if="visitEcho.has_vsd">
            <div class="">
              <div class="font-weight-bold text-uppercase">VSD</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="w-50">Size (mm): <span class="font-weight-bold">{{ visitEcho.param_rv_size }}</span></td>
                <td class="w-50">IVG (mm): <span class="font-weight-bold">{{ visitEcho.param_rv_ivg }}</span></td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEchoRemarks.RIGHT_VENTRICLE.length > 0">
            <ol>
              <li v-for="item in visitEchoRemarks.RIGHT_VENTRICLE">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: right-ventricle -->

        <!-- section: right-atrium -->
        <div class="section border p-2 mb-3" v-if="visitEchoRemarks.RIGHT_ATRIUM.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Right Atrium</h5>
          </div>

          <div class="" v-if="visitEchoRemarks.RIGHT_ATRIUM.length > 0">
            <ol>
              <li v-for="item in visitEchoRemarks.RIGHT_ATRIUM">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: right-atrium -->

        <!-- section: pulmonic valve -->
        <div class="section border p-2 mb-3">

          <div class="">
            <h5 class="font-weight-bold">Pulmonic Valve</h5>
          </div>


          <div class="" v-if="visitEcho.has_ps">
            <div class="">
              <div class="font-weight-bold text-uppercase">Has PS</div>
            </div>

            <table class="table table-bordered table-sm">
              <tr>
                <td class="w-50">PS (mmHg): <span class="font-weight-bold">{{ visitEcho.param_pv_pg }}</span></td>
                <td class="w-50">PV Annulus (mm): <span class="font-weight-bold">{{ visitEcho.param_pv_annulus }}</span></td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEchoRemarks.PULMONIC_VALVE.length > 0">
            <ol>
              <li v-for="item in visitEchoRemarks.PULMONIC_VALVE">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: pulmonic valve -->

        <!-- section: tricuspid -->
        <div class="section border p-2 mb-3" v-if="visitEchoRemarks.TRICUSPID.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Tricuspid</h5>
          </div>

          <div class="" v-if="visitEchoRemarks.TRICUSPID.length > 0">
            <ol>
              <li v-for="item in visitEchoRemarks.TRICUSPID">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: tricuspid -->

        <!-- section: pericardium -->
        <div class="section border p-2 mb-3" v-if="visitEchoRemarks.PERICARDIUM.length > 0">

          <div class="">
            <h5 class="font-weight-bold">Pericardium</h5>
          </div>

          <div class="" v-if="visitEchoRemarks.PERICARDIUM.length > 0">
            <ol>
              <li v-for="item in visitEchoRemarks.PERICARDIUM">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: pericardium -->

        <!-- section: conclusions -->
        <div class="section border p-2 mb-3" v-if="visitEchoRemarks.CONCLUSION.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Conclusions</h5>
          </div>

          <div class="" v-if="visitEchoRemarks.CONCLUSION.length > 0">
            <ol>
              <li v-for="item in visitEchoRemarks.CONCLUSION">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: conclusions -->


      </div><!-- section-echo-report -->

      <div v-else>
        <TheLoading/>
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


  </div><!-- template -->

</template>

<script>
import PatientBasicDetails from "./basic_report_sections/PatientBasicDetails";
import {errorMessageBox} from "../../../_common/bootbox_dialogs";
import TheLoading from "../../../_common/components/TheLoading";

export default {
  name: "EchoReportView",
  components: { TheLoading, PatientBasicDetails },
  data() {
    return {
      loaded: false,
    }
  },

  computed: {

    visitEcho() {
      return this.$store.getters.getVisitEcho;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },

    allEchoRemarks: function () {
      return this.$store.getters.getEchoRemarks
    },

    visitEchoRemarks: function () {
      return this.$store.getters.getVisitEchoRemarks
    },

    eOverA() {
      if ( this.visitEcho.param_dd_a === 0 ) return 0;
      return ( this.visitEcho.param_dd_e / this.visitEcho.param_dd_a ).toFixed( 2 );
    },

    eOverEBar() {
      if ( this.visitEcho.param_dd_e_bar === 0 ) return 0;
      return ( this.visitEcho.param_dd_e / this.visitEcho.param_dd_e_bar ).toFixed( 2 );
    },

    cardiacIndex() {
      if ( this.visitEcho.param_cardiac_output === 0 ) return 0;
      return this.visitEcho.param_cardiac_output / this.visitEcho.visit.bsa;
    }


  },

  async mounted() {
    try {

      await this.$store.dispatch( "visitEcho_fetch", this.visitId );


    } catch ( e ) {
      errorMessageBox( "Failed to fetch echo details" );
    }

    /* fetch all echo remarks */
    try {

      await this.$store.dispatch( "echo_fetchAllRemarks" );
      await this.$store.dispatch( "echo_fetchAllVisitRemarks", this.visitId );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch remarks" );
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

  .section {
    break-inside: avoid;
  }
}

</style>
