<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header">
        Echocardiography
      </div>

      <div class="card-body">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th style="width: 20%" class="text-right">Parameter</th>
            <th style="width: 13.3%" class="text-right">Value</th>
            <th style="width: 20%" class="text-right">Doppler Velocities & Hemodynamic Measures</th>
            <th style="width: 13.3%" class="text-right">Value</th>
            <th style="width: 20%" class="text-right">Doppler Velocities & Hemodynamic Measures</th>
            <th style="width: 13.3%" class="text-right">Value</th>
          </tr>
          </thead>
          <tbody>

          <tr>
            <td class="text-right align-middle">LA Systolic Diameter (mm)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_la_systolic_diameter"></td>
            <td class="text-right align-middle">Peak Aortic Velocity (cm/s)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_peak_aortic_velocity"></td>
            <td class="text-right align-middle">Stroke Volume (ml)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_stroke_volume"></td>
          </tr>

          <tr>
            <td class="text-right align-middle">Aortic Root Diameter (mm)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_aortic_root_diameter"></td>
            <td class="text-right align-middle">Peak LVOT Velocity (cm/s)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_peak_lvot_velocity"></td>
            <td class="text-right align-middle">Cardiac Output (l/s)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_cardiac_output"></td>
          </tr>

          <tr>
            <td class="text-right align-middle">LVOT Diameter (mm)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_lvot_diameter"></td>
            <td class="text-right align-middle">Aortic/LVOT Velocity (cm/s)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_aortic_lvot_velocity"></td>
            <td class="text-right align-middle">Cardiac Index (l/min/m²)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_cardiac_index"></td>
          </tr>

          <tr>
            <td class="text-right align-middle">RVID (mm)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_rvid"></td>
            <td class="text-right align-middle">Peak Aortic Gradient (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_peak_aortic_gradient"></td>
            <td class="text-right align-middle">BP (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_bp">
            </td>
          </tr>

          <tr>
            <td class="text-right align-middle">IVS Diastolic Thickness (mm)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_ivs_diastolic_thickness"></td>
            <td class="text-right align-middle">Mean Aortic Gradient (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_mean_aortic_gradient"></td>
            <td class="text-right align-middle">HR (beat/min)</td>
            <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_hr">
            </td>
          </tr>

          <tr>
            <td class="text-right align-middle">PW Diastolic Thickness (mm)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_pw_diastolic_thickness"></td>
            <td class="text-right align-middle">Aortic Valve Area (mm²)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_aortic_valve_area"></td>
            <td class="text-right align-middle">Est. RVSP (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_est_rvsp"></td>
          </tr>

          <tr>
            <td class="text-right align-middle">LVID Diastole (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_lvid_diastole"></td>
            <td class="text-right align-middle">Mitral Pressure 1/2 T (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_mitral_pressure"></td>
            <td class="text-right align-middle">Est. CVP (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_est_cvp"></td>
          </tr>

          <tr>
            <td class="text-right align-middle">LVID Systole (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_lvid_systole"></td>
            <td class="text-right align-middle">Mean Mitral Gradient (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_mean_mitral_gradient"></td>
            <td class="text-right align-middle">Est. PASP (mmHg)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_est_pasp"></td>
          </tr>

          <tr>
            <td class="text-right align-middle">Fractional Shortening</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_fractional_shortening"></td>
            <td class="text-right align-middle">Mitral Valve Area (mm²)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_mitral_valve_area"></td>
            <td class="text-right"></td>
            <td></td>
          </tr>

          <tr>
            <td class="text-right align-middle">LVEF (%)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_lvef"></td>
            <td class="text-right align-middle">Peak Tricuspid Velocity (cm/s)</td>
            <td><input type="number" class="form-control form-control-sm text-right"
                       v-model.number="visitEcho.param_peak_tricuspid_velocity"></td>
            <td class="text-right"></td>
            <td></td>
          </tr>

          </tbody>
        </table>

        <div class="text-center my-3">
          <button class="btn btn-success" @click="onUpdate" :disabled="!loaded">Update</button>
        </div>

        <VisitEchoReports/>

      </div>
    </div><!-- card -->

  </div><!-- template -->

</template>

<script>

import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";
import VisitEchoReports from "./echo/VisitEchoReports";

export default {
  name: "VisitEchoView",
  components: {VisitEchoReports},
  data() {
    return {
      exist: false,
      loaded: false,

    }
  },

  computed: {

    visitId: function () {
      return this.$store.getters.getVisitId;
    },

    visitEcho() {
      return this.$store.getters.getVisitEcho;
    }

  },

  async mounted() {

    try {


      await this.$store.dispatch("visitEcho_fetch", this.visitId);
      this.loaded = true;

    } catch (e) {
      errorMessageBox("Failed to fetch echo details");
    }

  },

  methods: {


    /*
    * Update new values
    * */
    async onUpdate() {

      try {

        const params = {
          id: this.visitEcho.id,
          param_la_systolic_diameter: this.visitEcho.param_la_systolic_diameter,
          param_aortic_root_diameter: this.visitEcho.param_aortic_root_diameter,
          param_lvot_diameter: this.visitEcho.param_lvot_diameter,
          param_ivs_diastolic_thickness: this.visitEcho.param_ivs_diastolic_thickness,
          param_pw_diastolic_thickness: this.visitEcho.param_pw_diastolic_thickness,
          param_lvid_diastole: this.visitEcho.param_lvid_diastole,
          param_lvid_systole: this.visitEcho.param_lvid_systole,
          param_fractional_shortening: this.visitEcho.param_fractional_shortening,
          param_lvef: this.visitEcho.param_lvef,
          param_rvid: this.visitEcho.param_rvid,
          param_peak_aortic_velocity: this.visitEcho.param_peak_aortic_velocity,
          param_peak_lvot_velocity: this.visitEcho.param_peak_lvot_velocity,
          param_aortic_lvot_velocity: this.visitEcho.param_aortic_lvot_velocity,
          param_peak_aortic_gradient: this.visitEcho.param_peak_aortic_gradient,
          param_mean_aortic_gradient: this.visitEcho.param_mean_aortic_gradient,
          param_aortic_valve_area: this.visitEcho.param_aortic_valve_area,
          param_mitral_pressure: this.visitEcho.param_mitral_pressure,
          param_mean_mitral_gradient: this.visitEcho.param_mean_mitral_gradient,
          param_mitral_valve_area: this.visitEcho.param_mitral_valve_area,
          param_peak_tricuspid_velocity: this.visitEcho.param_peak_tricuspid_velocity,
          param_stroke_volume: this.visitEcho.param_stroke_volume,
          param_cardiac_output: this.visitEcho.param_cardiac_output,
          param_cardiac_index: this.visitEcho.param_cardiac_index,
          param_bp: this.visitEcho.param_bp,
          param_hr: this.visitEcho.param_hr,
          param_est_rvsp: this.visitEcho.param_est_rvsp,
          param_est_cvp: this.visitEcho.param_est_cvp,
          param_est_pasp: this.visitEcho.param_est_pasp,
        }

        await this.$store.dispatch("visitEcho_update", params);

        successMessageBox("Echo details updated");

      } catch (e) {
        errorMessageBox("Failed to update echocardiography details");
      }

    },

  },

}
</script>

<style scoped>

</style>
