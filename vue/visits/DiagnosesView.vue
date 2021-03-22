<template>

  <div>

    <div class="container pb-5">

      <div class="row">
        <div class="col">
          <h3 class="text-center">Investigations & Diagnoses</h3>
        </div>
      </div>

      <div class="row mb-3">
        <!-- Symptoms -->
        <div class="col">
          <VisitSymptoms/>
        </div><!-- col -->
      </div>

      <div class="row mb-3">
        <!-- Differential diagnosis -->
        <div class="col">
          <DifferentialDiagnosis/>
        </div><!-- col -->

      </div>

      <div class="row mb-3">

        <!-- Investigations -->
        <div class="col-12">
          <VisitInvestigations/>
        </div><!-- col -->

      </div><!-- row -->

      <div class="row">
        <div class="col-12">
          <VisitDiagnosis/>
        </div>
      </div><!-- row -->

    </div>

  </div>

</template>

<script>

import VisitSymptoms from "./components/VisitSymptoms";
import DifferentialDiagnosis from "./components/DifferentialDiagnosis";
import VisitDiagnosis from "./components/VisitDiagnosis";
import VisitInvestigations from "./components/VisitInvestigations";

export default {
  name: "DiagnosesView",
  components: {VisitSymptoms, DifferentialDiagnosis, VisitDiagnosis, VisitInvestigations},

  computed: {

    visitId: function () {
      return this.$store.getters.getVisitId
    },

  },
  /* *** COMPUTED *** */

  mounted() {

    this.$store.dispatch('fetchVisitSymptoms', this.visitId)
    this.$store.dispatch('fetchDifferentialDiagnosis', this.visitId)
    this.$store.dispatch('fetchVisitInvestigations', this.visitId)
    this.$store.dispatch('fetchVisitDiagnosis', this.visitId)

  },
  /* *** MOUNTED *** */
}
</script>

<style scoped>

</style>
