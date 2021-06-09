<template>

  <div>

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
<!--        <DifferentialDiagnosis/>-->
      </div><!-- col -->

    </div>

    <div class="row mb-3">

      <!-- Investigations -->
      <div class="col-12">
<!--        <VisitInvestigations/>-->
      </div><!-- col -->

    </div><!-- row -->

    <div class="row">
      <div class="col-12">
<!--        <VisitDiagnosis/>-->
      </div>
    </div><!-- row -->

  </div>

</template>

<script>

import VisitSymptoms from "./../components/VisitSymptoms";
import DifferentialDiagnosis from "./../components/DifferentialDiagnosis";
import VisitDiagnosis from "./../components/VisitDiagnosis";
import VisitInvestigations from "./../components/VisitInvestigations";

export default {
  name: "DiagnosesView",
  components: {VisitSymptoms, DifferentialDiagnosis, VisitDiagnosis, VisitInvestigations},

}
</script>

<style scoped>

</style>
