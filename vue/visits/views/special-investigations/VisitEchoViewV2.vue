<template>

  <div class="card shadow shadow-sm">
    <div class="card-header">
      Echocardiography
    </div>

    <div class="card-body">

      <!-- section: Left Ventricle -->
      <div class="card mb-3">
        <div class="card-header">Left Ventricle</div>
        <div class="card-body">

          <div class="form-row">

            <div class="col-3 mb-2">
              IVS Diastolic Thickness (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_ivs_diastolic_thickness">
            </div>
            <div class="col-3 mb-2">
              LVID Diastole (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvid_diastole">
            </div>
            <div class="col-3 mb-2">
              PW Diastolic Thickness (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pw_diastolic_thickness">
            </div>

            <div class="col-3 mb-2">
              LVEF (%)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvef">
            </div>

            <div class="col-3 mb-2">
              Fractional Shortening
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_fractional_shortening">
            </div>
            <div class="col-3 mb-2">
              LVID Systole (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvid_systole">
            </div>
            <div class="col-3 mb-2">
              LVEF (%)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvef">
            </div>
          </div>

          <hr>
          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_diastolic_dysfunction" v-model="visitEcho.has_diastolic_dysfunction">
              <label class="form-check-label" for="chk_diastolic_dysfunction">Diastolic Dysfunction</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.has_diastolic_dysfunction">
            <div class="col-3 mb-2">
              A
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_a">
            </div>
            <div class="col-3 mb-2">
              E
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_e">
            </div>
            <div class="col-3 mb-2">
              E'
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_e_bar">
            </div>

            <div class="w-100 mb-2"></div>
            <div class="col-3 mb-2">
              E/A
              <input type="number" class="form-control form-control-sm" :value="eOverA">
            </div>
            <div class="col-3 mb-2">
              E/E'
              <input type="number" class="form-control form-control-sm" :value="eOverEBar">
            </div>

          </div>

          <hr>

          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_show_advanced" v-model="visitEcho.show_advanced">
              <label class="form-check-label" for="chk_show_advanced">Advanced</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.show_advanced">

            <div class="col-3 mb-2">
              Stroke Volume (ml)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_stroke_volume">
            </div>
            <div class="col-3 mb-2">
              Cardiac Output (l/min)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_cardiac_output">
            </div>
            <div class="col-3 mb-2">
              HR (beat/min)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_hr">
            </div>
            <div class="col-3 mb-2">
              BP (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_bp">
            </div>

            <div class="col-3 mb-2">
              Cardiac Index (l/min/m²)
              <input type="number" class="form-control form-control-sm" :value="cardiacIndex">
            </div>
          </div>


        </div>
      </div>
      <!-- section: Left Ventricle -->


      <!-- section: Left Atrium -->
      <div class="card mb-3">
        <div class="card-header">Left Atrium</div>
        <div class="card-body">

          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_is_left_atrium_dilated" v-model="visitEcho.is_left_atrium_dilated">
              <label class="form-check-label" for="chk_is_left_atrium_dilated">Is dilated</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.is_left_atrium_dilated">
            <div class="col-3 mb-2">
              LA Systolic Diameter (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_la_systolic_diameter">
            </div>
            <div class="col-3 mb-2">
              LA Area<br>(mm²)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_la_area">
            </div>
          </div>

          <hr>

          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_has_asd" v-model="visitEcho.has_asd">
              <label class="form-check-label" for="chk_has_asd">Has ASD</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.has_asd">
            <div class="col-3 mb-2">
              ASD Size (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_asd_size">
            </div>
          </div>

        </div>
      </div>
      <!-- section: Left Atrium -->


      <!-- section: Mitral Valve -->
      <div class="card mb-3">
        <div class="card-header">Mitral Valve</div>
        <div class="card-body">

          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_has_mitral_stenosis" v-model="visitEcho.has_mitral_stenosis">
              <label class="form-check-label" for="chk_has_mitral_stenosis">Has Mitral Stenosis</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.has_mitral_stenosis">
            <div class="col-3 mb-2">
              Mitral Pressure 1/2 T (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mitral_pressure">
            </div>
            <div class="col-3 mb-2">
              Mean Mitral Gradient (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mean_mitral_gradient">
            </div>
            <div class="col-3 mb-2">
              Doppler Mitral Valve Area (mm²)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_doppler_mitral_valve_area">
            </div>
            <div class="col-3 mb-2">
              Trace Mitral Valve Area (mm²)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_trace_mitral_valve_area">
            </div>
            <div class="col-3 mb-2">
              MV Score
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mv_score">
            </div>
          </div>

        </div>
      </div>
      <!-- section: Mitral Valve -->

      <!-- section: Aortic Valve -->
      <div class="card mb-3">
        <div class="card-header">Aortic Valve</div>
        <div class="card-body">

          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_is_diseased_aortic_valve" v-model="visitEcho.is_diseased_aortic_valve">
              <label class="form-check-label" for="chk_is_diseased_aortic_valve">Diseased</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.is_diseased_aortic_valve">
            <div class="col-3 mb-2">
              Peak Aortic Gradient (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_aortic_gradient">
            </div>
            <div class="col-3 mb-2">
              Mean Aortic Gradient (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mean_aortic_gradient">
            </div>
            <div class="col-3 mb-2">
              Aortic Valve Area (mm²)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aortic_valve_area">
            </div>
            <div class="col-3 mb-2">
              Peak Aortic Velocity (cm/s)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_aortic_velocity">
            </div>

            <div class="col-3 mb-2">
              Peak Aortic Velocity (cm/s)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_aortic_velocity">
            </div>

            <div class="col-3 mb-2">
              Peak LVOT Velocity (cm/s)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_lvot_velocity">
            </div>
            <div class="col-3 mb-2">
              Aortic/LVOT Velocity (cm/s)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aortic_lvot_velocity">
            </div>
            <div class="col-3 mb-2">
              ARPHT <br> (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_arpht">
            </div>

            <div class="col-3 mb-2">
              LVOT Diameter (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvot_diameter">
            </div>

          </div>

        </div>
      </div>
      <!-- section: Aortic Valve -->


      <!-- section: Aorta -->
      <div class="card mb-3">
        <div class="card-header">Aorta</div>
        <div class="card-body">

          <div class="form-row">
            <div class="col-3 mb-2">
              Root (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_root">
            </div>
            <div class="col-3 mb-2">
              Annulus (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_annulus">
            </div>

            <div class="col-3 mb-2">
              ST Junction (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_st_junction">
            </div>

            <div class="col-3 mb-2">
              Proximal Aorta (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_proximal">
            </div>

            <div class="col-3 mb-2">
              Aortic Arch (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_aortic_arch">
            </div>
          </div>

          <hr>

          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_is_diseased_aorta" v-model="visitEcho.is_diseased_aorta">
              <label class="form-check-label" for="chk_is_diseased_aorta">Diseased</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.is_diseased_aorta">
            <div class="col-3 mb-2">
              Aortic Root Diameter (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aortic_root_diameter">
            </div>
          </div>

        </div>
      </div>
      <!-- section: Aorta -->


      <!-- section: Right Ventricle / Pulmonary Artery -->
      <div class="card mb-3">
        <div class="card-header">Right Ventricle / Pulmonary Artery</div>
        <div class="card-body">

          <div class="form-row">

            <div class="col-3 mb-2">
              TAPSE <br> (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_tapse">
            </div>

            <div class="col-3 mb-2">
              Peak Tricuspid Velocity (cm/s)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_tricuspid_velocity">
            </div>

            <div class="col-3 mb-2">
              Est. RVSP <br> (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_rvsp">
            </div>

            <div class="col-3 mb-2">
              Est. CVP <br> (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_cvp">
            </div>

            <div class="col-3 mb-2">
              Est. PASP (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_pasp">
            </div>

            <div class="col-3 mb-2">
              Est. CVP (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_cvp">
            </div>

            <div class="col-3 mb-2">
              MPA (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mpa">
            </div>

            <div class="col-3 mb-2">
              RVOT1 (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvot1">
            </div>

            <div class="col-3 mb-2">
              RVOT2 (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvot2">
            </div>

            <div class="col-3 mb-2">
              RVOTAT (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvotat">
            </div>

            <div class="col-3 mb-2">
              RVID (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvid">
            </div>

          </div>

          <hr>

          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_has_vsd" v-model="visitEcho.has_vsd">
              <label class="form-check-label" for="chk_has_vsd">VSD</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.has_vsd">
            <div class="col-3 mb-2">
              Size (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rv_size">
            </div>
            <div class="col-3 mb-2">
              IVG (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rv_ivg">
            </div>
          </div>


        </div>
      </div>
      <!-- section: Right Ventricle / Pulmonary Artery -->

      <!-- section: Right Atrium -->
      <div class="card mb-3">
        <div class="card-header">Right Atrium</div>
        <div class="card-body">

        </div>
      </div>
      <!-- section: Right Atrium -->


      <!-- section: Pulmonic Valve -->
      <div class="card mb-3">
        <div class="card-header">Pulmonic Valve</div>
        <div class="card-body">

          <div class="mb-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="chk_has_ps" v-model="visitEcho.has_ps">
              <label class="form-check-label" for="chk_has_ps">PS</label>
            </div>
          </div>

          <div class="form-row" v-if="visitEcho.has_ps">
            <div class="col-3 mb-2">
              PS (mmHg)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pv_pg">
            </div>
            <div class="col-3 mb-2">
              PV Annulus (mm)
              <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pv_annulus">
            </div>
          </div>

        </div>
      </div>
      <!-- section: Pulmonic Valve -->


      <!-- section: Tricuspid -->
      <div class="card mb-3">
        <div class="card-header">Tricuspid</div>
        <div class="card-body">

        </div>
      </div>
      <!-- section: Tricuspid -->

      <!-- section: Pericardium -->
      <div class="card mb-3">
        <div class="card-header">Pericardium</div>
        <div class="card-body">

        </div>
      </div>
      <!-- section: Pericardium -->


      <!-- section: Conclusions -->
      <div class="card mb-3">
        <div class="card-header">Conclusions</div>
        <div class="card-body">

        </div>
      </div>
      <!-- section: Conclusions -->


      <div class="text-center">
        <button class="btn btn-success" @click="onUpdate()">Update</button>
      </div>


    </div><!-- card-body -->

  </div><!-- card -->

</template>

<script>
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "VisitEchoViewV2",

  data() {
    return {};
  },

  computed: {

    visitEcho() {
      return this.$store.getters.getVisitEcho;
    },

    visitId() {
      return this.$store.getters.getVisitId;
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
      // this.loaded = true;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch echo details" );
    }
  },


  methods: {

    async onUpdate() {

      try {

        await this.$store.dispatch( "visitEcho_update", this.visitEcho );
        successMessageBox( "Echocardiogram details updated" );
      } catch ( e ) {
        errorMessageBox( "Failed to update echocardiogram details" );
      }

    }, /* update */

  },

}
</script>

<style scoped>

</style>
