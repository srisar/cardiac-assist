<template>

  <div>

    <div class="container-fluid">
      <div class="row">

        <div class="col-12 col-md-3 col-xl-2">

          <div class="card mb-3 shadow shadow-sm">
            <div class="card-header">Basics</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <router-link to="/" class="">Visit Details</router-link>
              </li>
            </ul>
          </div><!-- card -->

          <div class="card mb-3 shadow shadow-sm">
            <div class="card-header">Diagnoses</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <router-link to="/diagnoses" class="">Diagnoses</router-link>
              </li>
            </ul>
          </div><!-- card -->


          <div class="card mb-3 shadow shadow-sm">
            <div class="card-header">Special Investigations</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <router-link to="/special/ecg" class="">Electrocardiogram (ECG)</router-link>
              </li>
              <li class="list-group-item">
                <router-link to="/special/lipids" class="">Lipids</router-link>
              </li>
              <li class="list-group-item">
                <router-link to="/special/coronary-ct" class="">Coronary CT</router-link>
              </li>
              <li class="list-group-item">
                <router-link to="/special/echo" class="">Echocardiogram</router-link>
              </li>
              <li class="list-group-item">
                <router-link to="/special/angio" class="">Angiography</router-link>
              </li>
            </ul>
          </div><!-- card -->

          <div class="card mb-3 shadow shadow-sm">
            <div class="card-header">Interventions</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <router-link to="/prescriptions" class="">Prescriptions</router-link>
              </li>

              <li class="list-group-item">
                <router-link to="/referral-letters" class="">Referral letter</router-link>
              </li>
              <li class="list-group-item">
                <router-link to="/review" class="">Review</router-link>
              </li>
              <li class="list-group-item">
                <router-link to="/further-investigations" class="">Further investigations</router-link>
              </li>
              <li class="list-group-item">
                <router-link to="/others" class="">Others</router-link>
              </li>
            </ul>
          </div><!-- card -->

          <div class="card mb-3 shadow shadow-sm">
            <div class="card-header">Reports</div>
            <ul class="list-group list-group-flush">


            </ul>
          </div><!-- card -->


        </div><!-- col -->

        <div class="col-md-9 col-xl-10">
          <transition name="fade" mode="out-in">
            <router-view></router-view>
          </transition>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

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


.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

</style>
