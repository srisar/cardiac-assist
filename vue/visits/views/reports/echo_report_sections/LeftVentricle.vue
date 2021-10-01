<template>

  <!-- section:Left Ventricle -->
  <div class="mb-1 section" v-if="!empty">

    <div class="">
      <h5 class="font-weight-bold text-uppercase">Left Ventricle</h5>
    </div>


    <table class="table table-sm table-bordered" v-if="!emptyTopSection">
      <tbody>
      <tr>

        <td>
          <div class="d-flex justify-content-between">

            <div class="" v-if="visitEcho.param_ivs_diastolic_thickness">
              IVS:
              <span class="font-weight-bold">{{ visitEcho.param_ivs_diastolic_thickness }}mm</span>
            </div>
            <div class="" v-if="visitEcho.param_lvid_diastole">
              LVID D:
              <span class="font-weight-bold">{{ visitEcho.param_lvid_diastole }}mm</span>
            </div>
            <div class="" v-if="visitEcho.param_pw_diastolic_thickness">
              PW:
              <span class="font-weight-bold">{{ visitEcho.param_pw_diastolic_thickness }}mm</span>
            </div>
            <div class="" v-if="visitEcho.param_lvef">
              LVEF:
              <span class="font-weight-bold">{{ visitEcho.param_lvef }}%</span>
            </div>
            <div class="" v-if="visitEcho.param_fractional_shortening">
              FS:
              <span class="font-weight-bold">{{ visitEcho.param_fractional_shortening }}</span>
            </div>
            <div class="" v-if="visitEcho.param_lvid_systole">
              LVID S:
              <span class="font-weight-bold">{{ visitEcho.param_lvid_systole }}mm</span>
            </div>

          </div>
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

          <td>
            <div class="d-flex justify-content-between">

              <div class="">A: <span class="font-weight-bold">{{ visitEcho.param_dd_a }}</span></div>
              <div class="">E: <span class="font-weight-bold">{{ visitEcho.param_dd_e }}</span></div>
              <div class="">E': <span class="font-weight-bold">{{ visitEcho.param_dd_e_bar }}</span></div>
              <div class="">E/A: <span class="font-weight-bold">{{ eOverA }}</span></div>
              <div class="">E/E': <span class="font-weight-bold">{{ eOverEBar }}</span></div>

            </div>
          </td>


        </tr>
      </table>

    </div>


    <div class="" v-if="visitEcho.show_advanced">
      <div class="">
        <div class="font-weight-bold text-uppercase sub-title">Advanced</div>
      </div>

      <table class="table table-sm table-bordered">
        <tr>
          <td>
            <div class="d-flex justify-content-between">

              <div class="text-center" v-if="visitEcho.param_stroke_volume">
                <div>Stroke Vol.:</div>
                <span class="font-weight-bold">{{ visitEcho.param_stroke_volume }}ml</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_cardiac_output">
                <div>Car. Output:</div>
                <span class="font-weight-bold">{{ visitEcho.param_cardiac_output }}l/min</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_hr">
                <div>HR:</div>
                <span class="font-weight-bold">{{ visitEcho.param_hr }}beats/min</span>
              </div>
              <div class="text-center" v-if="visitEcho.param_bp">
                <div>BP:</div>
                <span class="font-weight-bold">{{ visitEcho.param_bp }}mmHg</span>
              </div>
              <div class="text-center" v-if="cardiacIndex">
                <div>Car. Index:</div>
                <span class="font-weight-bold">{{ cardiacIndex }}l/min/m²</span>
              </div>

            </div>
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

</template>

<script>
export default {
  name: 'LeftVentricle',

  props: {
    visitEcho: {
      required: true,
    },
    visitEchoRemarks: {
      required: true,
    },
  },


  computed: {

    cardiacIndex() {
      if ( this.visitEcho.param_cardiac_output === 0 ) return 0;
      return ( this.visitEcho.param_cardiac_output / this.visitEcho.visit.bsa ).toFixed( 2 );
    },

    eOverA() {
      if ( this.visitEcho.param_dd_a === 0 ) return 0;
      return ( this.visitEcho.param_dd_e / this.visitEcho.param_dd_a ).toFixed( 2 );
    },

    eOverEBar() {
      if ( this.visitEcho.param_dd_e_bar === 0 ) return 0;
      return ( this.visitEcho.param_dd_e / this.visitEcho.param_dd_e_bar ).toFixed( 2 );
    },

    /**
     * Checks if the whole sections is empty.
     */
    empty() {

      return (
          this.emptyTopSection &&
          this.visitEcho.has_diastolic_dysfunction === false &&
          this.visitEchoRemarks.LEFT_VENTRICLE.length === 0

      );
    },


    emptyTopSection() {
      return (
          this.visitEcho.param_ivs_diastolic_thickness === null &&
          this.visitEcho.param_lvid_diastole === null &&
          this.visitEcho.param_pw_diastolic_thickness === null &&
          this.visitEcho.param_lvef === null &&
          this.visitEcho.param_fractional_shortening === null &&
          this.visitEcho.param_lvid_systole === null
      );
    },


  },

};
</script>

<style scoped>

</style>
