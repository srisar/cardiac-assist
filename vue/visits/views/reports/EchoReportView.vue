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


      <h3 class="text-center">Echocardiogram Report</h3>

      <PatientBasicDetails/>

      <div class="section-echo-report mt-3" v-if="loaded">


        <!-- section:Left Ventricle -->
        <div class="mb-3 section">

          <div class="">
            <h5 class="font-weight-bold text-uppercase lead">Left Ventricle</h5>
          </div>


          <table class="table table-sm table-bordered">
            <tbody>
            <tr>
              <td class="" v-if="visitEcho.param_ivs_diastolic_thickness">
                IVS:
                <span class="font-weight-bold">{{ visitEcho.param_ivs_diastolic_thickness }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_lvid_diastole">
                LVID D:
                <span class="font-weight-bold">{{ visitEcho.param_lvid_diastole }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_pw_diastolic_thickness">
                PW:
                <span class="font-weight-bold">{{ visitEcho.param_pw_diastolic_thickness }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_lvef">
                LVEF:
                <span class="font-weight-bold">{{ visitEcho.param_lvef }} %</span>
              </td>
              <td class="" v-if="visitEcho.param_fractional_shortening">
                FS:
                <span class="font-weight-bold">{{ visitEcho.param_fractional_shortening }}</span>
              </td>
              <td class="" v-if="visitEcho.param_lvid_systole">
                LVID S:
                <span class="font-weight-bold">{{ visitEcho.param_lvid_systole }} mmHg</span>
              </td>
            </tr>
            </tbody>
          </table>

          <div class="" v-if="visitEcho.has_diastolic_dysfunction">
            <div class="">
              <div class="font-weight-bold text-uppercase sub-title">Has diastolic dysfunction</div>
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
                <td class="text-center" v-if="visitEcho.param_stroke_volume">
                  Stroke Vol.:
                  <span class="font-weight-bold">{{ visitEcho.param_stroke_volume }} ml</span>
                </td>
                <td class="text-center" v-if="visitEcho.param_cardiac_output">
                  Car. Output:
                  <span class="font-weight-bold">{{ visitEcho.param_cardiac_output }} l/min</span>
                </td>
                <td class="text-center" v-if="visitEcho.param_hr">
                  HR:
                  <span class="font-weight-bold">{{ visitEcho.param_hr }} beat/min</span>
                </td>
                <td class="text-center" v-if="visitEcho.param_bp">
                  BP:
                  <span class="font-weight-bold">{{ visitEcho.param_bp }} mmHg</span>
                </td>
                <td class="text-center" v-if="cardiacIndex">
                  Car. Index:
                  <span class="font-weight-bold">{{ cardiacIndex }} l/min/m²</span>
                </td>
              </tr>

            </table>

          </div>

          <div class="" v-if="visitEchoRemarks.LEFT_VENTRICLE.length > 0">
            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.LEFT_VENTRICLE">
                {{ item.value }}
              </li>
            </ul>
          </div>

        </div>
        <!-- section:Left Ventricle -->

        <!-- section: Left Atrium -->
        <div class="mb-3 section" v-if="isLeftAtriumSectionVisible">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Left Atrium</h5>
          </div>

          <div v-if="visitEcho.is_left_atrium_dilated">

            <div class="">
              <div class="font-weight-bold text-uppercase">Is dilated</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="w-50" v-if="visitEcho.param_la_systolic_diameter">
                  LA Systolic Diameter:
                  <span class="font-weight-bold">{{ visitEcho.param_la_systolic_diameter }} mm</span>
                </td>
                <td class="w-50" v-if="visitEcho.param_la_area">
                  LA Area:
                  <span class="font-weight-bold">{{ visitEcho.param_la_area }} mm²</span>
                </td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEcho.has_asd && visitEcho.param_asd_size">

            <div class="">
              <div class="font-weight-bold text-uppercase">Has ASD</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="w-50">
                  ASD Size:
                  <span class="font-weight-bold">{{ visitEcho.param_asd_size }} mm</span>
                </td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEchoRemarks.LEFT_ATRIUM.length > 0">

            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.LEFT_ATRIUM">
                {{ item.value }}
              </li>
            </ul>
          </div>

        </div>
        <!-- section: Left Atrium -->

        <!-- section: mitral valve -->
        <div class="mb-3 section" v-if="visitEcho.has_mitral_stenosis || visitEchoRemarks.MITRAL_VALVE.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Mitral Valve</h5>
          </div>

          <div class="" v-if="visitEcho.has_mitral_stenosis">

            <div class="">
              <div class="font-weight-bold text-uppercase">Has Mitral Stenosis</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="" v-if="visitEcho.param_mitral_pressure">
                  Mitral Pressure 1/2 T:
                  <span class=" font-weight-bold">{{ visitEcho.param_mitral_pressure }} mmHg</span>
                </td>
                <td class="" v-if="visitEcho.param_mean_mitral_gradient">
                  Mean Mitral Gradient:
                  <span class=" font-weight-bold">{{ visitEcho.param_mean_mitral_gradient }} mmHg</span>
                </td>
                <td class="" v-if="visitEcho.param_doppler_mitral_valve_area">
                  Doppler Mitral VA:
                  <span class=" font-weight-bold">{{ visitEcho.param_doppler_mitral_valve_area }} mm²</span>
                </td>
                <td class="" v-if="visitEcho.param_trace_mitral_valve_area">
                  Trace Mitral VA:
                  <span class="font-weight-bold">{{ visitEcho.param_trace_mitral_valve_area }} mm²</span>
                </td>
                <td class="" v-if="visitEcho.param_mv_score">
                  MV Score:
                  <span class="font-weight-bold">{{ visitEcho.param_mv_score }}</span>
                </td>
              </tr>

            </table>

          </div>

          <div class="" v-if="visitEchoRemarks.MITRAL_VALVE.length > 0">

            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.MITRAL_VALVE">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: mitral valve -->

        <!-- section: aortic valve -->
        <div class="section mb-3" v-if="isAorticValveVisible">

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
                <td class="5" v-if="visitEcho.param_peak_aortic_gradient">
                  Peak AG
                  <span class="font-weight-bold">{{ visitEcho.param_peak_aortic_gradient }} mmHg</span>
                </td>
                <td class="" v-if="visitEcho.param_mean_aortic_gradient">
                  Mean AG:
                  <span class="font-weight-bold">{{ visitEcho.param_mean_aortic_gradient }} mmHg</span>
                </td>
                <td class="" v-if="visitEcho.param_aortic_valve_area">
                  Aortic VA:
                  <span class="font-weight-bold">{{ visitEcho.param_aortic_valve_area }} mm²</span>
                </td>
                <td class="" v-if="visitEcho.param_peak_aortic_velocity">
                  Peak AV:
                  <span class="font-weight-bold">{{ visitEcho.param_peak_aortic_velocity }} cm/s</span>
                </td>
              </tr>
              <tr>
                <td v-if="visitEcho.param_peak_lvot_velocity">
                  Peak LVOT V:
                  <span class="font-weight-bold">{{ visitEcho.param_peak_lvot_velocity }} cm/s</span>
                </td>
                <td class="" v-if="visitEcho.param_aortic_lvot_velocity">
                  Aortic/LVOT V:
                  <span class="font-weight-bold">{{ visitEcho.param_aortic_lvot_velocity }} cm/s</span>
                </td>
                <td class="" v-if="visitEcho.param_arpht">
                  ARPHT:
                  <span class="font-weight-bold">{{ visitEcho.param_arpht }} mm</span>
                </td>
                <td class="" v-if="visitEcho.param_lvot_diameter">
                  LVOT Diameter:
                  <span class="font-weight-bold">{{ visitEcho.param_lvot_diameter }} mm</span>
                </td>
              </tr>
            </table>

          </div>

          <div class="" v-if="visitEchoRemarks.AORTIC_VALVE.length > 0">

            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.AORTIC_VALVE">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: aortic valve -->

        <!-- section: aorta -->
        <div class="section mb-3" v-if="showAortaSection">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Aorta</h5>
          </div>

          <table class="table table-sm table-bordered" v-if="visitEcho.has_aorta">
            <tr>
              <td class="" v-if="visitEcho.param_aorta_root">
                Root:
                <span class="font-weight-bold">{{ visitEcho.param_aorta_root }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_aorta_annulus">
                Annulus:
                <span class="font-weight-bold">{{ visitEcho.param_aorta_annulus }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_aorta_st_junction">
                ST Junction:
                <span class="font-weight-bold">{{ visitEcho.param_aorta_st_junction }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_aorta_proximal">
                Proximal Aorta:
                <span class="font-weight-bold">{{ visitEcho.param_aorta_proximal }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_aorta_aortic_arch">
                Aortic Arch:
                <span class="font-weight-bold">{{ visitEcho.param_aorta_aortic_arch }} mm</span>
              </td>
            </tr>
          </table>

          <div class="" v-if="visitEcho.is_diseased_aorta">
            <div class="">
              <div class="font-weight-bold text-uppercase">Diseased</div>
            </div>

            <table class="table table-bordered table-sm">
              <tr>
                <td>Aortic Root Diameter:
                  <span class="font-weight-bold">{{ visitEcho.param_aortic_root_diameter }} mm</span>
                </td>
              </tr>
            </table>

          </div>

          <div class="" v-if="visitEchoRemarks.AORTA.length > 0">
            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.AORTA">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: aorta -->

        <!-- section: right-ventricle -->
        <div class="section mb-3" v-if="isRightVentricleVisible">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Right Ventricle / Pulmonary Artery</h5>
          </div>

          <div>TV = Tricuspid Velocity</div>
          <table class="table table-bordered table-sm">
            <tr>
              <td class="" v-if="visitEcho.param_tapse">
                TAPSE:
                <span class=" font-weight-bold">{{ visitEcho.param_tapse }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_peak_tricuspid_velocity">
                Peak TV:
                <span class="text-center font-weight-bold">{{ visitEcho.param_peak_tricuspid_velocity }} cm/s</span>
              </td>
              <td class="" v-if="visitEcho.param_est_rvsp">
                Est. RVSP:
                <span class=" font-weight-bold">{{ visitEcho.param_est_rvsp }} mmHg</span>
              </td>
              <td class="" v-if="visitEcho.param_est_cvp">
                Est. CVP:
                <span class="text-center font-weight-bold">{{ visitEcho.param_est_cvp }} mmHg</span>
              </td>

            </tr>

            <tr>
              <td class="" v-if="visitEcho.param_est_pasp">
                Est. PASP:
                <span class="font-weight-bold">{{ visitEcho.param_est_pasp }} mmHg</span>
              </td>
              <td class="" v-if="visitEcho.param_est_cvp">
                Est. CVP:
                <span class="font-weight-bold">{{ visitEcho.param_est_cvp }} mmHg</span>
              </td>
              <td class="" v-if="visitEcho.param_mpa">
                MPA:
                <span class="font-weight-bold">{{ visitEcho.param_mpa }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_rvot1">
                RVOT1:
                <span class="font-weight-bold">{{ visitEcho.param_rvot1 }} mm</span>
              </td>
            </tr>

            <tr>
              <td class="" v-if="visitEcho.param_rvot2">
                RVOT2:
                <span class="font-weight-bold">{{ visitEcho.param_rvot2 }} mm</span>
              </td>
              <td class="" v-if="visitEcho.param_rvotat">
                RVOTAT:
                <span class="font-weight-bold">{{ visitEcho.param_rvotat }} ms</span>
              </td>
              <td class="" v-if="visitEcho.param_rvid">
                RVID:
                <span class="font-weight-bold">{{ visitEcho.param_rvid }} mm</span>
              </td>
              <td></td>
            </tr>

          </table>


          <div class="" v-if="visitEcho.has_vsd && (visitEcho.param_rv_size || visitEcho.param_rv_ivg)">
            <div class="">
              <div class="font-weight-bold text-uppercase">VSD</div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <td class="w-50" v-if="visitEcho.param_rv_size">
                  Size: <span class="font-weight-bold">{{ visitEcho.param_rv_size }} mm</span></td>
                <td class="w-50" v-if="visitEcho.param_rv_ivg">
                  IVG: <span class="font-weight-bold">{{ visitEcho.param_rv_ivg }} mm</span></td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEchoRemarks.RIGHT_VENTRICLE.length > 0">
            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.RIGHT_VENTRICLE">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: right-ventricle -->

        <!-- section: right-atrium -->
        <div class="section mb-3" v-if="visitEchoRemarks.RIGHT_ATRIUM.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Right Atrium</h5>
          </div>

          <div class="" v-if="visitEchoRemarks.RIGHT_ATRIUM.length > 0">
            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.RIGHT_ATRIUM">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: right-atrium -->

        <!-- section: pulmonic valve -->
        <div class="section mb-3" v-if="showPulmonicValveSection">

          <div class="">
            <h5 class="font-weight-bold">Pulmonic Valve</h5>
          </div>


          <div class="" v-if="visitEcho.has_ps && (visitEcho.param_pv_pg || visitEcho.param_pv_annulus)">
            <div class="">
              <div class="font-weight-bold text-uppercase">Has PS</div>
            </div>

            <table class="table table-bordered table-sm">
              <tr>
                <td class="w-50" v-if="visitEcho.param_pv_pg">
                  PS: <span class="font-weight-bold">{{ visitEcho.param_pv_pg }} mmHg</span>
                </td>
                <td class="w-50" v-if="visitEcho.param_pv_annulus">
                  PV Annulus: <span class="font-weight-bold">{{ visitEcho.param_pv_annulus }} mm</span>
                </td>
              </tr>
            </table>

          </div>


          <div class="" v-if="visitEchoRemarks.PULMONIC_VALVE.length > 0">
            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.PULMONIC_VALVE">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: pulmonic valve -->

        <!-- section: tricuspid -->
        <div class="section mb-3" v-if="visitEchoRemarks.TRICUSPID.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Tricuspid</h5>
          </div>

          <div class="" v-if="visitEchoRemarks.TRICUSPID.length > 0">
            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.TRICUSPID">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: tricuspid -->

        <!-- section: pericardium -->
        <div class="section mb-3" v-if="visitEchoRemarks.PERICARDIUM.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Pericardium</h5>
          </div>

          <div class="" v-if="visitEchoRemarks.PERICARDIUM.length > 0">
            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.PERICARDIUM">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: pericardium -->

        <!-- section: conclusions -->
        <div class="section mb-3" v-if="visitEchoRemarks.CONCLUSION.length > 0">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Conclusions</h5>
          </div>

          <div class="" v-if="visitEchoRemarks.CONCLUSION.length > 0">
            <ul class="list-unstyled">
              <li v-for="item in visitEchoRemarks.CONCLUSION">
                {{ item.value }}
              </li>
            </ul>
          </div>
        </div>
        <!-- section: conclusions -->


      </div><!-- section-echo-report -->

      <div v-else>
        <TheLoading/>
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


  </div><!-- template -->

</template>

<script>
import {errorMessageBox} from '../../../_common/bootbox_dialogs';
import TheLoading from '../../../_common/components/TheLoading';
import PatientBasicDetails from './basic_report_sections/PatientBasicDetails';

export default {
  name: 'EchoReportView',
  components: { TheLoading, PatientBasicDetails },
  data() {
    return {
      loaded: false,
      isEmsHeaderVisible: false,
    };
  },

  computed: {

    visitEcho() {
      return this.$store.getters.getVisitEcho;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },

    allEchoRemarks: function () {
      return this.$store.getters.getEchoRemarks;
    },

    visitEchoRemarks: function () {
      return this.$store.getters.getVisitEchoRemarks;
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
      return ( this.visitEcho.param_cardiac_output / this.visitEcho.visit.bsa ).toFixed( 2 );
    },

    /* section display logic */
    showAortaSection() {
      return this.visitEcho.has_aorta || this.visitEcho.is_diseased_aorta || this.visitEchoRemarks.AORTA.length > 0;
    },

    showPulmonicValveSection() {
      return this.visitEcho.has_ps || this.visitEchoRemarks.PULMONIC_VALVE.length > 0;
    },


    isLeftAtriumSectionVisible() {
      return this.visitEcho.is_left_atrium_dilated || this.visitEcho.has_asd || this.visitEchoRemarks.LEFT_ATRIUM.length > 0;
    },

    isAorticValveVisible() {
      return this.visitEcho.is_diseased_aortic_valve || this.visitEchoRemarks.AORTIC_VALVE.length > 0;
    },

    isRightVentricleVisible() {
      return this.visitEcho.param_tapse ||
          this.visitEcho.param_peak_tricuspid_velocity ||
          this.visitEcho.param_est_rvsp ||
          this.visitEcho.param_est_cvp ||
          this.visitEcho.param_est_rvsp ||
          this.visitEcho.param_mpa ||
          this.visitEcho.param_rvot1 ||
          this.visitEcho.param_rvot2 ||
          this.visitEcho.param_rvotat ||
          this.visitEcho.param_rvid ||
          this.visitEcho.has_vsd ||
          this.visitEchoRemarks.RIGHT_VENTRICLE.length > 0;
    },


  },
  /* -- computed -- */


  async mounted() {
    try {

      await this.$store.dispatch( 'visitEcho_fetch', this.visitId );


    } catch ( e ) {
      errorMessageBox( 'Failed to fetch echo details' );
    }

    /* fetch all echo remarks */
    try {

      await this.$store.dispatch( 'echo_fetchAllRemarks' );
      await this.$store.dispatch( 'echo_fetchAllVisitRemarks', this.visitId );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( 'Failed to fetch remarks' );
    }
  },

  methods: {
    openPrintDialog() {
      window.print();
    },
  },

};
</script>

<style lang="scss" scoped>


</style>
