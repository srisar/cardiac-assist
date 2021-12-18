<template>
  <div class="mb-1 pdf-item" v-if="visitEchoRemarks.RIGHT_ATRIUM.length > 0">

    <div class="">
      <h5 class="section-header">Right Atrium</h5>
    </div>

    <div class="" v-if="visitEchoRemarks.RIGHT_ATRIUM.length > 0">
      <ul class="list-unstyled">
        <li v-for="item in visitEchoRemarks.RIGHT_ATRIUM">
          {{ item.value }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "RightAtrium",

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