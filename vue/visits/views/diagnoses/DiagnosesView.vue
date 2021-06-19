<template>

  <div>

    <div class="row mb-3">
      <!-- Symptoms -->
      <div class="col">
        <VisitSymptoms id="visit-symptoms"/>
      </div><!-- col -->
    </div>

    <div class="row mb-3">
      <!-- Differential diagnosis -->
      <div class="col">
        <DifferentialDiagnosis id="visit-diff-diagnoses"/>
      </div><!-- col -->

    </div>

    <div class="row mb-3">

      <!-- Investigations -->
      <div class="col-12">
        <VisitInvestigations id="visit-investigation"/>
      </div><!-- col -->

    </div><!-- row -->

    <div class="row mb-3">
      <div class="col-12">
        <VisitDiagnosis id="visit-diagnoses"/>
      </div>
    </div><!-- row -->

    <div class="row mb-3">
      <div class="col-12">
        <VisitProblems id="visit-problems"/>
      </div>
    </div><!-- row -->

  </div>

</template>

<script>

import VisitSymptoms from "./VisitSymptoms";
import DifferentialDiagnosis from "./DifferentialDiagnosis";
import VisitDiagnosis from "./VisitDiagnosis";
import VisitInvestigations from "./VisitInvestigations";
import VisitProblems from "./VisitProblems";

export default {
  name: "DiagnosesView",
  components: {VisitProblems, VisitSymptoms, DifferentialDiagnosis, VisitDiagnosis, VisitInvestigations},

}
</script>

<style scoped>

</style>
