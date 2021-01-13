<template>

  <div>

    <div class="container-fluid">

      <div class="row mb-3">
        <div class="col">
          <VisitDetails/>
        </div><!-- col -->
      </div><!-- row -->

      <div class="row mb-3">

        <!-- Symptoms -->
        <div class="col-6">
          <VisitSymptoms/>
        </div><!-- col -->

        <!-- Differential diagnosis -->
        <div class="col-6">

        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>

import store from './store';
import VisitDetails from "./components/VisitDetails";
import VisitSymptoms from "./components/VisitSymptoms";

export default {
  name: "ManageVisit",
  components: {VisitDetails, VisitSymptoms},
  store: store,

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
              .then(r => {

              })
              .catch(e => {
                console.log(e);
              })

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
