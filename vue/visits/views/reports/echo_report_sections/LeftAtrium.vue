<template>
  <div class="mb-1 pdf-item" v-if="isLeftAtriumSectionVisible">

    <div class="">
      <h5 class="section-header">Left Atrium</h5>
    </div>

    <div v-if="visitEcho.is_left_atrium_dilated">

      <div class="">
        <div class="font-weight-bold text-uppercase sub-title">Is dilated</div>
      </div>

      <table class="table table-sm table-bordered">
        <tr>
          <td class="w-50" v-if="visitEcho.param_la_systolic_diameter">
            LA Systolic Diameter:
            <span class="font-weight-bold">{{ visitEcho.param_la_systolic_diameter }}mm</span>
          </td>
          <td class="w-50" v-if="visitEcho.param_la_area">
            LA Area:
            <span class="font-weight-bold">{{ visitEcho.param_la_area }}mm²</span>
          </td>
        </tr>
      </table>

    </div>


    <div class="" v-if="visitEcho.has_asd && visitEcho.param_asd_size">

      <div class="">
        <div class="font-weight-bold text-uppercase sub-title">Has ASD</div>
      </div>

      <table class="table table-sm table-bordered">
        <tr>
          <td class="w-50">
            ASD Size:
            <span class="font-weight-bold">{{ visitEcho.param_asd_size }}mm</span>
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
</template>

<script>
export default {
  name: "LeftAtrium",
  props: {
    visitEcho: {
      required: true,
    },
    visitEchoRemarks: {
      required: true,
    },
  },

  computed: {
    isLeftAtriumSectionVisible() {
      return this.visitEcho.is_left_atrium_dilated || this.visitEcho.has_asd || this.visitEchoRemarks.LEFT_ATRIUM.length > 0;
    },
  },

}
</script>

<style scoped>

</style>