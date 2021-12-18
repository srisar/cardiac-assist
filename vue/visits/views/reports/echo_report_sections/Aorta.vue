<template>
  <div class="mb-1 pdf-item" v-if="showAortaSection">

    <div class="">
      <h5 class="section-header">Aorta</h5>
    </div>

    <table class="table table-sm table-bordered" v-if="visitEcho.has_aorta">
      <tr>

        <td>
          <div class="d-flex justify-content-between">

            <div class="text-center" v-if="visitEcho.param_aorta_root">
              Root:
              <span class="font-weight-bold">{{ visitEcho.param_aorta_root }}mm</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_aorta_annulus">
              Annulus:
              <span class="font-weight-bold">{{ visitEcho.param_aorta_annulus }}mm</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_aorta_st_junction">
              ST Junction:
              <span class="font-weight-bold">{{ visitEcho.param_aorta_st_junction }}mm</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_aorta_proximal">
              Proximal Aorta:
              <span class="font-weight-bold">{{ visitEcho.param_aorta_proximal }}mm</span>
            </div>
            <div class="text-center" v-if="visitEcho.param_aorta_aortic_arch">
              Aortic Arch:
              <span class="font-weight-bold">{{ visitEcho.param_aorta_aortic_arch }}mm</span>
            </div>

          </div>
        </td>


      </tr>
    </table>

    <div class="" v-if="visitEcho.is_diseased_aorta">
      <div class="">
        <div class="font-weight-bold text-uppercase">Diseased</div>
      </div>

      <table class="table table-bordered table-sm">
        <tr>
          <td>Aortic Root Diameter:
            <span class="font-weight-bold">{{ visitEcho.param_aortic_root_diameter }} mm</span>
          </td>
        </tr>
      </table>

    </div>

    <div class="" v-if="visitEchoRemarks.AORTA.length > 0">
      <ul class="list-unstyled">
        <li v-for="item in visitEchoRemarks.AORTA">
          {{ item.value }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "Aorta",

  props: {
    visitEcho: {
      required: true,
    },
    visitEchoRemarks: {
      required: true,
    },
  },

  computed: {
    showAortaSection() {
      return this.visitEcho.has_aorta || this.visitEcho.is_diseased_aorta || this.visitEchoRemarks.AORTA.length > 0;
    },
  },

}
</script>

<style scoped>

</style>