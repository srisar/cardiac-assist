<template>
  <div class="mb-1 pdf-item" v-if="showPulmonicValveSection">

    <div class="">
      <h5 class="section-header">Pulmonic Valve</h5>
    </div>


    <div class="" v-if="visitEcho.has_ps && (visitEcho.param_pv_pg || visitEcho.param_pv_annulus)">
      <div class="">
        <div class="font-weight-bold text-uppercase sub-title">Has PS</div>
      </div>

      <table class="table table-bordered table-sm">
        <tr>

          <td>
            <div class="d-flex justify-content-center" style="gap: 1rem">

              <div class="" v-if="visitEcho.param_pv_pg">
                PS: <span class="font-weight-bold">{{ visitEcho.param_pv_pg }}mmHg</span>
              </div>
              <div class="" v-if="visitEcho.param_pv_annulus">
                PV Annulus: <span class="font-weight-bold">{{ visitEcho.param_pv_annulus }}mm</span>
              </div>

            </div>
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
</template>

<script>
export default {
  name: "PulmonicValve",

  props: {
    visitEcho: {
      required: true,
    },
    visitEchoRemarks: {
      required: true,
    },
  },

  computed: {
    showPulmonicValveSection() {
      return this.visitEcho.has_ps || this.visitEchoRemarks.PULMONIC_VALVE.length > 0;
    },
  },

}
</script>

<style scoped>

</style>