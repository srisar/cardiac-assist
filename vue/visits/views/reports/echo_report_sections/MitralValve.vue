<template>
  <div class="mb-1 pdf-item" v-if="visitEcho.has_mitral_stenosis || visitEchoRemarks.MITRAL_VALVE.length > 0">

    <div class="">
      <h5 class="section-header">Mitral Valve</h5>
    </div>

    <div class="" v-if="visitEcho.has_mitral_stenosis">

      <div class="">
        <div class="font-weight-bold text-uppercase sub-title">Has Mitral Stenosis</div>
      </div>

      <table class="table table-sm table-bordered">
        <tr>

          <td>
            <div class="d-flex justify-content-between">

              <div class="text-center" v-if="visitEcho.param_mitral_pressure">
                <div>Mitral Pressure 1/2 T:</div>
                <div class="font-weight-bold">{{ visitEcho.param_mitral_pressure }}mmHg</div>
              </div>

              <div class="text-center" v-if="visitEcho.param_mean_mitral_gradient">
                <div>Mean Mitral Gradient:</div>
                <span class="font-weight-bold">{{ visitEcho.param_mean_mitral_gradient }}mmHg</span>
              </div>

              <div class="text-center" v-if="visitEcho.param_doppler_mitral_valve_area">
                <div>Doppler Mitral VA:</div>
                <span class="font-weight-bold">{{ visitEcho.param_doppler_mitral_valve_area }}mm²</span>
              </div>

              <div class="text-center" v-if="visitEcho.param_trace_mitral_valve_area">
                <div>Trace Mitral VA:</div>
                <span class="font-weight-bold">{{ visitEcho.param_trace_mitral_valve_area }}mm²</span>
              </div>

              <div class="text-center" v-if="visitEcho.param_mv_score">
                <div>MV Score:</div>
                <span class="font-weight-bold">{{ visitEcho.param_mv_score }}</span>
              </div>

            </div>
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
</template>

<script>
export default {
  name: "MitralValve",

  props: {
    visitEcho: {
      required: true,
    },
    visitEchoRemarks: {
      required: true,
    },
  },
}
</script>

<style scoped>

</style>