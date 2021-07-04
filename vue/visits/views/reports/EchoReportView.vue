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

          <div class="form-row">

            <div class="col-3 mb-2">
              IVS Diastolic Thickness <br> (mm)
              <div class="font-weight-bold">{{ visitEcho.param_ivs_diastolic_thickness }}</div>
            </div>
            <div class="col-3 mb-2">
              LVID Diastole <br> (mmHg)
              <div class="font-weight-bold">{{ visitEcho.param_lvid_diastole }}</div>
            </div>
            <div class="col-3 mb-2">
              PW Diastolic Thickness <br> (mm)
              <div class="font-weight-bold">{{ visitEcho.param_pw_diastolic_thickness }}</div>
            </div>

            <div class="col-3 mb-2">
              LVEF <br> (%)
              <div class="font-weight-bold">{{ visitEcho.param_lvef }}</div>
            </div>

            <div class="col-3 mb-2">
              Fractional Shortening
              <div class="font-weight-bold">{{ visitEcho.param_fractional_shortening }}</div>
            </div>
            <div class="col-3 mb-2">
              LVID Systole (mmHg)
              <div class="font-weight-bold">{{ visitEcho.param_lvid_systole }}</div>
            </div>
          </div>


          <div class="" v-if="visitEcho.has_diastolic_dysfunction">
            <div class="">
              <hr>
              <div class="font-weight-bold">Has diastolic dysfunction</div>
            </div>

            <div class="form-row">
              <div class="col-2 mb-2">
                A
                <div class="font-weight-bold">{{ visitEcho.param_dd_a }}</div>
              </div>
              <div class="col-2 mb-2">
                E
                <div class="font-weight-bold">{{ visitEcho.param_dd_e }}</div>
              </div>
              <div class="col-2 mb-2">
                E'
                <div class="font-weight-bold">{{ visitEcho.param_dd_e_bar }}</div>
              </div>
              <div class="col-2 mb-2">
                E/A
                <div class="font-weight-bold">{{ eOverA }}</div>
              </div>
              <div class="col-2 mb-2">
                E/E'
                <div class="font-weight-bold">{{ eOverEBar }}</div>
              </div>
            </div>

          </div>


          <div class="" v-if="visitEcho.show_advanced">
            <div class="">
              <hr>
              <div class="font-weight-bold text-uppercase">Advanced</div>
            </div>

            <div class="form-row">
              <div class="col-2 mb-2">
                Stroke Volume <br> (ml)
                <div class="font-weight-bold">{{ visitEcho.param_stroke_volume }}</div>
              </div>
              <div class="col-2 mb-2">
                Cardiac Output <br> (l/min)
                <div class="font-weight-bold">{{ visitEcho.param_cardiac_output }}</div>
              </div>
              <div class="col-2 mb-2">
                HR <br> (beat/min)
                <div class="font-weight-bold">{{ visitEcho.param_hr }}</div>
              </div>
              <div class="col-2 mb-2">
                BP <br> (mmHg)
                <div class="font-weight-bold">{{ visitEcho.param_bp }}</div>
              </div>

              <div class="col-2 mb-2">
                Cardiac Index <br> (l/min/m²)
                <div class="font-weight-bold">{{ cardiacIndex }}</div>
              </div>
            </div>
          </div>

          <div class="" v-if="visitEchoRemarks.LEFT_VENTRICLE.length > 0">
            <hr>
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
              <hr>
              <div class="font-weight-bold">Is dilated</div>
            </div>

            <div class="form-row">
              <div class="col-3 mb-2">
                LA Systolic Diameter <br> (mm)
                <div class="font-weight-bold">{{ visitEcho.param_la_systolic_diameter }}</div>
              </div>
              <div class="col-3 mb-2">
                LA Area<br>(mm²)
                <div class="font-weight-bold">{{ visitEcho.param_la_area }}</div>
              </div>
            </div>
          </div>


          <div class="" v-if="visitEcho.has_asd">

            <div class="">
              <hr>
              <div class="font-weight-bold">Has ASD</div>
            </div>

            <div class="form-row">
              <div class="col-3 mb-2">
                ASD Size (mm)
                <div class="font-weight-bold">{{ visitEcho.param_asd_size }}</div>
              </div>
            </div>
          </div>


          <div class="" v-if="visitEchoRemarks.LEFT_ATRIUM.length > 0">
            <hr>
            <ol>
              <li v-for="item in visitEchoRemarks.LEFT_ATRIUM">
                {{ item.value }}
              </li>
            </ol>
          </div>

        </div>
        <!-- section: Left Atrium -->

        <!-- section: mitral valve -->
        <div class="border p-2 mb-3 section">

          <div class="">
            <h5 class="font-weight-bold text-uppercase">Mitral Valve</h5>
          </div>

          <div class="" v-if="visitEcho.has_mitral_stenosis">

            <div class="">
              <div class="font-weight-bold">Has Mitral Stenosis</div>
            </div>

            <div class="form-row">
              <div class="col-3 mb-2">
                Mitral Pressure 1/2 T (mmHg)
                <div class="font-weight-bold">{{ visitEcho.param_mitral_pressure }}</div>
              </div>
              <div class="col-3 mb-2">
                Mean Mitral Gradient (mmHg)
                <div class="font-weight-bold">{{ visitEcho.param_mean_mitral_gradient }}</div>
              </div>
              <div class="col-3 mb-2">
                Doppler Mitral Valve Area (mm²)
                <div class="font-weight-bold">{{ visitEcho.param_doppler_mitral_valve_area }}</div>
              </div>
              <div class="col-3 mb-2">
                Trace Mitral Valve Area (mm²)
                <div class="font-weight-bold">{{ visitEcho.param_trace_mitral_valve_area }}</div>
              </div>
              <div class="col-3 mb-2">
                MV Score
                <div class="font-weight-bold">{{ visitEcho.param_mv_score }}</div>
              </div>
            </div>
          </div>

          <div class="" v-if="visitEchoRemarks.MITRAL_VALVE.length > 0">
            <hr>
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

            <div class="form-row">
              <div class="col-3 mb-2">
                Peak Aortic Gradient <br> (mmHg)
                <div class="font-weight-bold">{{ visitEcho.param_peak_aortic_gradient }}</div>
              </div>
              <div class="col-3 mb-2">
                Mean Aortic Gradient <br> (mmHg)
                <div class="font-weight-bold">{{ visitEcho.param_mean_aortic_gradient }}</div>
              </div>
              <div class="col-3 mb-2">
                Aortic Valve Area <br> (mm²)
                <div class="font-weight-bold">{{ visitEcho.param_aortic_valve_area }}</div>
              </div>
              <div class="col-3 mb-2">
                Peak Aortic Velocity <br> (cm/s)
                <div class="font-weight-bold">{{ visitEcho.param_peak_aortic_velocity }}</div>
              </div>

              <div class="col-3 mb-2">
                Peak Aortic Velocity <br> (cm/s)
                <div class="font-weight-bold">{{ visitEcho.param_peak_aortic_velocity }}</div>
              </div>

              <div class="col-3 mb-2">
                Peak LVOT Velocity <br> (cm/s)
                <div class="font-weight-bold">{{ visitEcho.param_peak_lvot_velocity }}</div>
              </div>
              <div class="col-3 mb-2">
                Aortic/LVOT Velocity <br> (cm/s)
                <div class="font-weight-bold">{{ visitEcho.param_aortic_lvot_velocity }}</div>
              </div>
              <div class="col-3 mb-2">
                ARPHT <br> (mm)
                <div class="font-weight-bold">{{ visitEcho.param_arpht }}</div>
              </div>

              <div class="col-3 mb-2">
                LVOT Diameter <br> (mm)
                <div class="font-weight-bold">{{ visitEcho.param_lvot_diameter }}</div>
              </div>
            </div>

          </div>


          <div class="" v-if="visitEchoRemarks.AORTIC_VALVE.length > 0">
            <hr>
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

          <div class="form-row">
            <div class="col-2 mb-2">
              Root <br> (mm)
              <div class="font-weight-bold">{{ visitEcho.param_aorta_root }}</div>
            </div>
            <div class="col-2 mb-2">
              Annulus <br> (mm)
              <div class="font-weight-bold">{{ visitEcho.param_aorta_annulus }}</div>
            </div>

            <div class="col-2 mb-2">
              ST Junction <br> (mm)
              <div class="font-weight-bold">{{ visitEcho.param_aorta_st_junction }}</div>
            </div>

            <div class="col-2 mb-2">
              Proximal Aorta <br> (mm)
              <div class="font-weight-bold">{{ visitEcho.param_aorta_proximal }}</div>
            </div>

            <div class="col-2 mb-2">
              Aortic Arch <br> (mm)
              <div class="font-weight-bold">{{ visitEcho.param_aorta_aortic_arch }}</div>
            </div>
          </div>

          <div class="" v-if="visitEcho.is_diseased_aorta">
            <div class="">
              <div class="font-weight-bold">Diseased</div>
            </div>

            <div class="form-row">
              <div class="col-3 mb-2">
                Aortic Root Diameter (mm)
                <div class="font-weight-bold">{{ visitEcho.param_aortic_root_diameter }}</div>
              </div>
            </div>
          </div>

          <div class="" v-if="visitEchoRemarks.AORTA.length > 0">
            <hr>
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

          <div class="form-row">

            <div class="col-3 mb-2">
              TAPSE <br> (mm)
              <div class="font-weight-bold">{{ visitEcho.param_tapse }}</div>
            </div>

            <div class="col-3 mb-2">
              Peak Tricuspid Velocity (cm/s)
              <div class="font-weight-bold">{{ visitEcho.param_peak_tricuspid_velocity }}</div>
            </div>

            <div class="col-3 mb-2">
              Est. RVSP <br> (mmHg)
              <div class="font-weight-bold">{{ visitEcho.param_est_rvsp }}</div>
            </div>

            <div class="col-3 mb-2">
              Est. CVP <br> (mmHg)
              <div class="font-weight-bold">{{ visitEcho.param_est_cvp }}</div>
            </div>

            <div class="col-3 mb-2">
              Est. PASP (mmHg)
              <div class="font-weight-bold">{{ visitEcho.param_est_pasp }}</div>
            </div>

            <div class="col-3 mb-2">
              Est. CVP (mmHg)
              <div class="font-weight-bold">{{ visitEcho.param_est_cvp }}</div>
            </div>

            <div class="col-3 mb-2">
              MPA (mm)
              <div class="font-weight-bold">{{ visitEcho.param_mpa }}</div>
            </div>

            <div class="col-3 mb-2">
              RVOT1 (mm)
              <div class="font-weight-bold">{{ visitEcho.param_rvot1 }}</div>
            </div>

            <div class="col-3 mb-2">
              RVOT2 (mm)
              <div class="font-weight-bold">{{ visitEcho.param_rvot2 }}</div>
            </div>

            <div class="col-3 mb-2">
              RVOTAT (mm)
              <div class="font-weight-bold">{{ visitEcho.param_rvotat }}</div>
            </div>

            <div class="col-3 mb-2">
              RVID (mm)
              <div class="font-weight-bold">{{ visitEcho.param_rvid }}</div>
            </div>

          </div>


          <div class="" v-if="visitEcho.has_vsd">
            <div class="">
              <div class="font-weight-bold">VSD</div>
            </div>
            <div class="form-row">
              <div class="col-3 mb-2">
                Size (mm)
                <div class="font-weight-bold">{{ visitEcho.param_rv_size }}</div>
              </div>
              <div class="col-3 mb-2">
                IVG (mm)
                <div class="font-weight-bold">{{ visitEcho.param_rv_ivg }}</div>
              </div>
            </div>
          </div>


          <div class="" v-if="visitEchoRemarks.RIGHT_VENTRICLE.length > 0">
            <hr>
            <ol>
              <li v-for="item in visitEchoRemarks.RIGHT_VENTRICLE">
                {{ item.value }}
              </li>
            </ol>
          </div>
        </div>
        <!-- section: right-ventricle -->

        <!-- section: right-atrium -->
        <div class="section border p-2 mb-3">

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
              <div class="font-weight-bold">Has PS</div>
            </div>
            <div class="form-row">
              <div class="col-3 mb-2">
                PS (mmHg)
                <div class="font-weight-bold">{{ visitEcho.param_pv_pg }}</div>
              </div>
              <div class="col-3 mb-2">
                PV Annulus (mm)
                <div class="font-weight-bold">{{ visitEcho.param_pv_annulus }}</div>
              </div>
            </div>
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
        <div class="section border p-2 mb-3">

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
        <div class="section border p-2 mb-3">

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
        <div class="section border p-2 mb-3">

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
