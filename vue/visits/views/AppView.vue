<template>

  <div>

    <div class="container">
      <div class="row">
        <div class="col text-center py-3">

          <div class="btn-group" role="group" aria-label="Basic example">
            <router-link to="/" class="btn btn-primary">Visit Details</router-link>
            <router-link to="/diagnoses" class="btn btn-primary">Diagnoses</router-link>

            <div class="btn-group" role="group">
              <button id="btnGroupSpecialInvestigations" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Special Investigations
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <router-link to="/special/ecg" class="dropdown-item">Electrocardiogram (ECG)</router-link>
                <router-link to="/special/lipids" class="dropdown-item">Lipids</router-link>
                <router-link to="/special/coronary-ct" class="dropdown-item">Coronary CT</router-link>
                <router-link to="/special/echo" class="dropdown-item">Echocardiogram</router-link>
                <router-link to="/special/angio" class="dropdown-item">Angiography</router-link>
              </div>
            </div>

            <div class="btn-group" role="group">
              <button id="btnPlanOfManagement" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Plan of Management
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <router-link to="/pom/problems" class="dropdown-item">Problems List</router-link>
              </div>
            </div>

          </div>


        </div>
      </div>
    </div>


    <router-view></router-view>
  </div>

</template>

<script>
export default {
  name: "AppView",

  data() {
    return {}
  },


  beforeCreate() {

    const visitId = document.getElementById('php_visit_id').value

    /* 1. fetch visit details */
    this.$store.commit('updateVisitId', parseInt(visitId))
    this.$store.dispatch('fetchVisit', parseInt(visitId))
  },

  computed: {
    //
  },

  mounted() {


    /* 2. fetch investigations and diagnoses */
    /* it is done in DiagnosesView */


  },

}
</script>

<style>

@media (max-width: 768px) {

  .btn-group a, .btn-group button {
    font-size: 0.7em !important;
  }

}

</style>
