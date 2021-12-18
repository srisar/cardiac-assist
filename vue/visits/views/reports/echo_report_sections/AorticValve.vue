<template>
  <div class="mb-1 pdf-item" v-if="isAorticValveVisible">

    <div class="">
      <h5 class="section-header">Aortic Valve</h5>
    </div>


    <div class="" v-if="visitEcho.is_diseased_aortic_valve">

      <div class="font-weight-bold text-uppercase sub-title">Diseased</div>

      <div class="abbr">VA = Valve Area, AV = Aortic Velocity, AG = Aortic Gradient, V = velocity</div>
      <table class="table table-sm table-bordered">


        <tr>
          <td>
            <div class="d-flex flex-wrap justify-content-between">

              <div class="text-center" v-if="visitEcho.param_peak_aortic_gradient">
                <div>Peak AG:</div>
                <span class="font-weight-bold">{{ visitEcho.param_peak_aortic_gradient }}mmHg</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_mean_aortic_gradient">
                <div>Mean AG:</div>
                <span class="font-weight-bold">{{ visitEcho.param_mean_aortic_gradient }}mmHg</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_aortic_valve_area">
                <div>Aortic VA:</div>
                <span class="font-weight-bold">{{ visitEcho.param_aortic_valve_area }}mm²</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_peak_aortic_velocity">
                <div>Peak AV:</div>
                <span class="font-weight-bold">{{ visitEcho.param_peak_aortic_velocity }}cm/s</span>
              </div>

              <div class="text-center" v-if="visitEcho.param_peak_lvot_velocity">
                <div>Peak LVOT V:</div>
                <span class="font-weight-bold">{{ visitEcho.param_peak_lvot_velocity }}cm/s</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_aortic_lvot_velocity">
                <div>Aortic/LVOT V:</div>
                <span class="font-weight-bold">{{ visitEcho.param_aortic_lvot_velocity }}cm/s</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_arpht">
                <div>ARPHT:</div>
                <span class="font-weight-bold">{{ visitEcho.param_arpht }}mm</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_lvot_diameter">
                <div>LVOT Diameter:</div>
                <span class="font-weight-bold">{{ visitEcho.param_lvot_diameter }}mm</span>
              </div>

            </div>
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
</template>

<script>
export default {
  name: "AorticValve",

  props: {
    visitEcho: {
      required: true,
    },
    visitEchoRemarks: {
      required: true,
    },
  },

  computed: {

    isAorticValveVisible() {
      return this.visitEcho.is_diseased_aortic_valve || this.visitEchoRemarks.AORTIC_VALVE.length > 0;
    },
  },

}
</script>

<style scoped>

</style>