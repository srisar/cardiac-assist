<template>

  <div>

    <div class="container">
      <div class="row">
        <div class="col text-center py-3">

          <div class="btn-group" role="group" aria-label="Basic example">
            <router-link to="/" class="btn btn-primary">Visit Details</router-link>
            <router-link to="/diagnoses" class="btn btn-primary">Diagnoses</router-link>
            <router-link to="special" class="btn btn-primary">Special investigations</router-link>
          </div>


        </div>
      </div>
    </div>

    <div>

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
    this.$store.commit('updateVisitId', visitId)
    this.$store.dispatch('fetchVisit', visitId)
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

<style scoped>

</style>
