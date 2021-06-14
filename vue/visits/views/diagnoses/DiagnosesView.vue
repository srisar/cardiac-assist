<template>

  <div>

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

</template>

<script>

import VisitSymptoms from "./VisitSymptoms";
import DifferentialDiagnosis from "./DifferentialDiagnosis";
import VisitDiagnosis from "./VisitDiagnosis";
import VisitInvestigations from "./VisitInvestigations";

export default {
  name: "DiagnosesView",
  components: {VisitSymptoms, DifferentialDiagnosis, VisitDiagnosis, VisitInvestigations},

}
</script>

<style scoped>

</style>
