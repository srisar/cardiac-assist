<template>

  <div>

    <div class="container" v-if="!isLoading">

      <div class="row mb-3">
        <div class="col">
          <VisitDetails/>
        </div><!-- col -->
      </div><!-- row -->

      <div class="row mb-3">
        <!-- Symptoms -->
        <div class="col-12 col-lg-4">
          <VisitSymptoms/>
        </div><!-- col -->

        <!-- Differential diagnosis -->
        <div class="col-12 col-lg-8">
          <DifferentialDiagnosis/>
        </div><!-- col -->

      </div>

      <div class="row mb-3">

        <!-- Investigations -->
        <div class="col-12">
          <VisitInvestigations/>
        </div><!-- col -->

      </div><!-- row -->

      <div class="row mb-3">
        <div class="col-12">
          <VisitDiagnosis/>
        </div>
      </div><!-- row -->

      <div class="row mb-3">

        <!-- Special Investigations -->
        <div class="col-12">
          <SpecialInvestigations/>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

    <!--  -->
    <!--  -->
    <!-- Display page loading message -->
    <div v-else class="text-center">
      <p class="lead">Loading</p>
    </div>

  </div><!-- template -->

</template>

<script>

import VisitDetails from "./components/VisitDetails";
import VisitSymptoms from "./components/VisitSymptoms";
import DifferentialDiagnosis from "./components/DifferentialDiagnosis";
import VisitInvestigations from "./components/VisitInvestigations";
import SpecialInvestigations from "./components/SpecialInvestigations";
import VisitDiagnosis from "./components/VisitDiagnosis";

export default {
  name: "ManageVisit",
  components: {
    VisitDiagnosis,
    VisitInvestigations,
    VisitDetails,
    VisitSymptoms,
    DifferentialDiagnosis,
    SpecialInvestigations,
  },

  /*
  * === DATA ===
  * */
  data() {
    return {
      visitId: document.getElementById("php_visit_id").value,

      isLoading: true,

    }
  },

  /*
  * === COMPUTED ===
  * */
  computed: {},

  /*
  * === MOUNTED ===
  * */
  mounted() {

    /*
    * Fetch the visit details
    * */
    this.$store.dispatch('fetchVisit', this.visitId)
        .then(() => {

          this.$store.dispatch('fetchVisitSymptoms', this.visitId)
              .then(() => {

                this.$store.dispatch('fetchDifferentialDiagnosis', this.visitId)
                    .then(() => {

                      this.$store.dispatch('fetchVisitInvestigations', this.visitId)
                          .then(() => {

                            this.$store.dispatch('fetchVisitDiagnosis', this.visitId)
                                .then(() => {
                                  this.isLoading = false
                                })
                          }) /* fetch visit investigations */
                    }) /* fetch diff diagnoses */
              }) /* fetch visit symptoms */
        }) /* fetch visit */
        .catch(e => {
          console.log(e);
        });

  },
  /* *** MOUNTED *** */

}
</script>

<style scoped>

</style>
