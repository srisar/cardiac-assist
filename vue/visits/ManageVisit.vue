<template>

  <div>

    <div class="pt-2">


      <div class="container pb-5">

        <div class="row">
          <div class="col">
            <h3 class="text-center">Basic Details</h3>
          </div>
        </div>


        <div class="row">
          <div class="col">
            <VisitDetails/>
          </div><!-- col -->
        </div><!-- row -->
      </div>

    </div><!-- Visit details section -->


    <div class="bg-diagnosis pt-3">

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

    </div><!-- section diagnosis -->


    <div class="bg-special-investigations pt-3">

      <div class="container pb-5">

        <div class="row">
          <div class="col">
            <h3 class="text-center">Special Investigations</h3>
          </div>
        </div>

        <div class="row mb-3">

          <!-- Special Investigations -->
          <div class="col-12">
            <SpecialInvestigations/>
          </div><!-- col -->

        </div><!-- row -->

      </div><!-- container -->

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

.bg-diagnosis {
  background-color: #FEF5E6;
}

.bg-special-investigations {
  background-color: #EEE1FE;
}

</style>
