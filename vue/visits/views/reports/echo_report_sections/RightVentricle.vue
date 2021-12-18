<template>
  <div class="mb-1 pdf-item" v-if="isRightVentricleVisible">

    <div class="">
      <h5 class="section-header">Right Ventricle / Pulmonary Artery</h5>
    </div>

    <div class="abbr">TV = Tricuspid Velocity</div>
    <table class="table table-bordered table-sm">

      <tr>
        <td>
          <div class="d-flex justify-content-between">

            <div class="text-center" v-if="visitEcho.param_tapse">
              <div>TAPSE:</div>
              <span class=" font-weight-bold">{{ visitEcho.param_tapse }}mm</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_peak_tricuspid_velocity">
              <div>Peak TV:</div>
              <span class="text-center font-weight-bold">{{
                  visitEcho.param_peak_tricuspid_velocity
                }}cm/s</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_est_rvsp">
              <div>Est. RVSP:</div>
              <span class=" font-weight-bold">{{ visitEcho.param_est_rvsp }}mmHg</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_est_cvp">
              <div>Est. CVP:</div>
              <span class="text-center font-weight-bold">{{ visitEcho.param_est_cvp }}mmHg</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_est_pasp">
              <div>Est. PASP:</div>
              <span class="font-weight-bold">{{ visitEcho.param_est_pasp }}mmHg</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_mpa">
              <div>MPA:</div>
              <span class="font-weight-bold">{{ visitEcho.param_mpa }}mm</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_rvot1">
              <div>RVOT1:</div>
              <span class="font-weight-bold">{{ visitEcho.param_rvot1 }}mm</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_rvot2">
              <div>RVOT2:</div>
              <span class="font-weight-bold">{{ visitEcho.param_rvot2 }}mm</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_rvotat">
              <div>RVOTAT:</div>
              <span class="font-weight-bold">{{ visitEcho.param_rvotat }}ms</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_rvid">
              <div>RVID:</div>
              <span class="font-weight-bold">{{ visitEcho.param_rvid }}mm</span>
            </div>

          </div>
        </td>
      </tr>

    </table>


    <div class="" v-if="visitEcho.has_vsd && (visitEcho.param_rv_size || visitEcho.param_rv_ivg)">
      <div class="">
        <div class="font-weight-bold text-uppercase sub-title">VSD</div>
      </div>

      <table class="table table-sm table-bordered">
        <tr>
          <td>
            <div class="d-flex justify-content-center" style="gap: 1rem">

              <div class="" v-if="visitEcho.param_rv_size">
                Size: <span class="font-weight-bold">{{ visitEcho.param_rv_size }}mm</span>
              </div>
              <div class="" v-if="visitEcho.param_rv_ivg">
                IVG: <span class="font-weight-bold">{{ visitEcho.param_rv_ivg }}mm</span>
              </div>

            </div>
          </td>

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
</template>

<script>
export default {
  name: "RightVentricle",

  props: {
    visitEcho: {
      required: true,
    },
    visitEchoRemarks: {
      required: true,
    },
  },

  computed: {
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

}
</script>

<style scoped>

</style>