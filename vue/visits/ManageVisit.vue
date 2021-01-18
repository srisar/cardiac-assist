<template>

  <div>

    <div class="container">

      <div class="row mb-3">
        <div class="col">
          <VisitDetails/>
        </div><!-- col -->
      </div><!-- row -->

      <div class="row mb-3">

        <!-- Symptoms -->
        <div class="col-12 mb-3">
          <VisitSymptoms/>
        </div><!-- col -->

        <div class="w-100"></div>

        <!-- Differential diagnosis -->
        <div class="col-12 mb-3">
          <DifferentialDiagnosis/>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>

import VisitDetails from "./components/VisitDetails";
import VisitSymptoms from "./components/VisitSymptoms";
import DifferentialDiagnosis from "./components/DifferentialDiagnosis";

export default {
  name: "ManageVisit",
  components: {VisitDetails, VisitSymptoms, DifferentialDiagnosis},

  data() {
    return {
      visitId: document.getElementById("php_visit_id").value,
    }
  },

  computed: {},

  mounted() {

    /*
    * Fetch the visit details
    * */
    this.$store.dispatch('fetchVisit', this.visitId)
        .then(r => {

          // fetch visit-symptoms

          this.$store.dispatch('fetchVisitSymptoms', this.visitId)
              .catch(e => {
                console.log(e);
              });

          this.$store.dispatch('fetchDifferentialDiagnosis', this.visitId)
              .catch(e => {
                console.log(e);
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
