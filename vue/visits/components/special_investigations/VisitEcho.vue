<template>

  <div>

    <div>
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
          <td class="text-right align-middle">LA Systolic Diameter</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_la_systolic_diameter"></td>
          <td class="text-right align-middle">Peak Aortic Velocity</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_peak_aortic_velocity"></td>
          <td class="text-right align-middle">Stroke Volume</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_stroke_volume"></td>
        </tr>

        <tr>
          <td class="text-right align-middle">Aortic Root Diameter</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_aortic_root_diameter"></td>
          <td class="text-right align-middle">Peak LVOT Velocity</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_peak_lvot_velocity"></td>
          <td class="text-right align-middle">Cardiac Output</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_cardiac_output"></td>
        </tr>

        <tr>
          <td class="text-right align-middle">LVOT Diameter</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_lvot_diameter"></td>
          <td class="text-right align-middle">Aortic/LVOT Velocity</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_aortic_lvot_velocity"></td>
          <td class="text-right align-middle">Cardiac Index</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_cardiac_index"></td>
        </tr>

        <tr>
          <td class="text-right align-middle">RVID</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_rvid"></td>
          <td class="text-right align-middle">Peak Aortic Gradient</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_peak_aortic_gradient"></td>
          <td class="text-right align-middle">BP</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_bp"></td>
        </tr>

        <tr>
          <td class="text-right align-middle">IVS Diastolic Thickness</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_ivs_diastolic_thickness"></td>
          <td class="text-right align-middle">Mean Aortic Gradient</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_mean_aortic_gradient"></td>
          <td class="text-right align-middle">HR</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_hr"></td>
        </tr>

        <tr>
          <td class="text-right align-middle">PW Diastolic Thickness</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_pw_diastolic_thickness"></td>
          <td class="text-right align-middle">Aortic Valve Area</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_aortic_valve_area"></td>
          <td class="text-right align-middle">Est. RVSP</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_est_rvsp"></td>
        </tr>

        <tr>
          <td class="text-right align-middle">LVID Diastole</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_lvid_diastole"></td>
          <td class="text-right align-middle">Mitral Pressure 1/2 T</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_mitral_pressure"></td>
          <td class="text-right align-middle">Est. CVP</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_est_cvp"></td>
        </tr>

        <tr>
          <td class="text-right align-middle">LVID Systole</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_lvid_systole"></td>
          <td class="text-right align-middle">Mean Mitral Gradient</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_mean_mitral_gradient"></td>
          <td class="text-right align-middle">Est. PASP</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_est_pasp"></td>
        </tr>

        <tr>
          <td class="text-right align-middle">Fractional Shortening</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_fractional_shortening"></td>
          <td class="text-right align-middle">Mitral Valve Area</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_mitral_valve_area"></td>
          <td class="text-right"></td>
          <td></td>
        </tr>

        <tr>
          <td class="text-right align-middle">LVEF</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_lvef"></td>
          <td class="text-right align-middle">Peak Tricuspid Velocity</td>
          <td><input type="number" class="form-control form-control-sm text-right" v-model.number="visitEcho.param_peak_tricuspid_velocity"></td>
          <td class="text-right"></td>
          <td></td>
        </tr>

        </tbody>
      </table>

      <div class="text-center my-3">
        <button class="btn btn-success" @click="onUpdate">Update</button>
      </div>

      <!-- Reports -->

      <VisitEchoReports/>

      <!-- Reports -->


    </div>

  </div><!-- template -->

</template>

<script>

import VisitEchoReports from "./VisitEchoReports";

export default {
  name      : "VisitEchocardiography",
  components: { VisitEchoReports },
  /* ### DATA ### */
  data() {
    return {
      exist: false,

      visitEcho: {
        id                           : undefined,
        visit_id                     : undefined,
        param_la_systolic_diameter   : 0,
        param_aortic_root_diameter   : 0,
        param_lvot_diameter          : 0,
        param_ivs_diastolic_thickness: 0,
        param_pw_diastolic_thickness : 0,
        param_lvid_diastole          : 0,
        param_lvid_systole           : 0,
        param_fractional_shortening  : 0,
        param_lvef                   : 0,
        param_rvid                   : 0,
        param_peak_aortic_velocity   : 0,
        param_peak_lvot_velocity     : 0,
        param_aortic_lvot_velocity   : 0,
        param_peak_aortic_gradient   : 0,
        param_mean_aortic_gradient   : 0,
        param_aortic_valve_area      : 0,
        param_mitral_pressure        : 0,
        param_mean_mitral_gradient   : 0,
        param_mitral_valve_area      : 0,
        param_peak_tricuspid_velocity: 0,
        param_stroke_volume          : 0,
        param_cardiac_output         : 0,
        param_cardiac_index          : 0,
        param_bp                     : 0,
        param_hr                     : 0,
        param_est_rvsp               : 0,
        param_est_cvp                : 0,
        param_est_pasp               : 0,
      },
    }
  }, /* DATA */

  /* ### COMPUTED ### */
  computed: {

    visit: function () { return this.$store.getters.getVisit }

  }, /* COMPUTED */

  /* ### MOUNTED ### */
  mounted() {

    this._fetch()

  }, /* MOUNTED */

  /* ### METHODS ### */
  methods: {

    /*
    * Fetch
    * */
    _fetch: function () {

      const params = {
        visit_id: this.visit.id,
      }

      $.get(`${getSiteURL()}/api/get/visit-echo.php`, params)
          .done(response => {
            console.log(response.data)
            this.visitEcho = response.data
          })
          .fail(error => { })

    }, /* fetch */

    onUpdate: function () {
      const params = {
        id                           : this.visitEcho.id,
        param_la_systolic_diameter   : this.visitEcho.param_la_systolic_diameter,
        param_aortic_root_diameter   : this.visitEcho.param_aortic_root_diameter,
        param_lvot_diameter          : this.visitEcho.param_lvot_diameter,
        param_ivs_diastolic_thickness: this.visitEcho.param_ivs_diastolic_thickness,
        param_pw_diastolic_thickness : this.visitEcho.param_pw_diastolic_thickness,
        param_lvid_diastole          : this.visitEcho.param_lvid_diastole,
        param_lvid_systole           : this.visitEcho.param_lvid_systole,
        param_fractional_shortening  : this.visitEcho.param_fractional_shortening,
        param_lvef                   : this.visitEcho.param_lvef,
        param_rvid                   : this.visitEcho.param_rvid,
        param_peak_aortic_velocity   : this.visitEcho.param_peak_aortic_velocity,
        param_peak_lvot_velocity     : this.visitEcho.param_peak_lvot_velocity,
        param_aortic_lvot_velocity   : this.visitEcho.param_aortic_lvot_velocity,
        param_peak_aortic_gradient   : this.visitEcho.param_peak_aortic_gradient,
        param_mean_aortic_gradient   : this.visitEcho.param_mean_aortic_gradient,
        param_aortic_valve_area      : this.visitEcho.param_aortic_valve_area,
        param_mitral_pressure        : this.visitEcho.param_mitral_pressure,
        param_mean_mitral_gradient   : this.visitEcho.param_mean_mitral_gradient,
        param_mitral_valve_area      : this.visitEcho.param_mitral_valve_area,
        param_peak_tricuspid_velocity: this.visitEcho.param_peak_tricuspid_velocity,
        param_stroke_volume          : this.visitEcho.param_stroke_volume,
        param_cardiac_output         : this.visitEcho.param_cardiac_output,
        param_cardiac_index          : this.visitEcho.param_cardiac_index,
        param_bp                     : this.visitEcho.param_bp,
        param_hr                     : this.visitEcho.param_hr,
        param_est_rvsp               : this.visitEcho.param_est_rvsp,
        param_est_cvp                : this.visitEcho.param_est_cvp,
        param_est_pasp               : this.visitEcho.param_est_pasp,
      }

      $.post(`${getSiteURL()}/api/update/visit-echo.php`, params)
          .done(() => {
            alert("Echocardiography details updated");
          })
          .fail(e => {
            console.log(e);
            alert("Failed to update echocardiography details");
          });

    },

  }, /* METHODS */

}
</script>

<style scoped>

</style>
