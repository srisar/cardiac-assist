<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Report generation</div>
      <div class="card-body">

        <div class="mb-3">
          <h4>Visit report</h4>
          <p>
            Visit report includes basic patient details, diagnoses, investigations, problems
            and prescription. It is generated for A5 paper.
          </p>
          <router-link to="/reports/basic" class="btn btn-sm btn-outline-primary">
            <img src="/assets/images/actions/reports-basic.svg" class="icon-16" alt=""> Generate visit report
          </router-link>
          <hr>
        </div>

        <div class="mb-3">
          <h4>Special investigations reports</h4>
          <p>
            This includes individual special investigation reports.
          </p>

          <router-link to="/reports/echo" class="btn btn-sm btn-link mb-2">
            <img src="/assets/images/actions/reports.svg" class="icon-16" alt=""> Generate Echocardiography report
          </router-link>
          <br>

          <router-link to="/reports/angio" class="btn btn-sm btn-link mb-2">
            <img src="/assets/images/actions/reports.svg" class="icon-16" alt=""> Generate Angiography report
          </router-link>
          <br>

          <router-link to="/reports/cct" class="btn btn-sm btn-link mb-2">
            <img src="/assets/images/actions/reports.svg" class="icon-16" alt=""> Generate Coronary CT report
          </router-link>

          <hr>
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
