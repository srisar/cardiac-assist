<template>
  <div class="mb-1 pdf-item" v-if="visitEchoRemarks.TRICUSPID.length > 0">

    <div class="">
      <h5 class="section-header">Tricuspid</h5>
    </div>

    <div class="" v-if="visitEchoRemarks.TRICUSPID.length > 0">
      <ul class="list-unstyled">
        <li v-for="item in visitEchoRemarks.TRICUSPID">
          {{ item.value }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "Tricuspid",

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