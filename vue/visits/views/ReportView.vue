<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Report generation</div>
      <div class="card-body">

        <div class="text-center">
          <router-link class="btn btn-primary" to="/reports/basic">Generate basic report</router-link>
        </div>

      </div>
    </div>

  </div>

</template>

<script>
export default {
  name: "ReportView",

  data() {
    return {
      //
    }
  },

  computed: {
    //
  },

  mounted() {

    // this.$store.commit("hasSidebar", false);

  },

  methods: {
    //
  },

}
</script>

<style scoped>

</style>
