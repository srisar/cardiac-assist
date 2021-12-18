<template>
  <div class="mb-1 pdf-item" v-if="visitEchoRemarks.CONCLUSION.length > 0">

    <div class="">
      <h5 class="section-header">Conclusions</h5>
    </div>

    <div class="" v-if="visitEchoRemarks.CONCLUSION.length > 0">
      <ul class="list-unstyled">
        <li v-for="item in visitEchoRemarks.CONCLUSION">
          {{ item.value }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "Conclusion",

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