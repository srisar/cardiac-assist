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
        <div class="col-12 col-lg-4 mb-3">
          <VisitSymptoms/>
        </div><!-- col -->

        <!-- Differential diagnosis -->
        <div class="col-12 col-lg-8 mb-3">
          <DifferentialDiagnosis/>
        </div><!-- col -->

      </div>

      <div class="row mb-3">

        <!-- Investigations -->
        <div class="col-12 mb-3">
          <VisitInvestigations/>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

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

export default {
  name: "ManageVisit",
  components: {VisitInvestigations, VisitDetails, VisitSymptoms, DifferentialDiagnosis},

  data() {
    return {
      visitId: document.getElementById("php_visit_id").value,

      isLoading: true,

    }
  },

  computed: {},

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
                            this.isLoading = false;
                          });
                    });
              });
        })
        .catch(e => {
          console.log(e);
        });

  },

  methods: {
    //
  },
}
</script>

<style scoped>

</style>
