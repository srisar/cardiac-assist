<template>

  <div class="d-print-none sticky-top" style="top: 10px">

    <div class="card mb-3 shadow shadow-sm">
      <div class="card-header"><img src="/assets/images/icon-basics.svg" class="icon-24" alt="icon"> Basics</div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <router-link to="/" class="">
            Visit Details
          </router-link>
        </li>
      </ul>
    </div><!-- card -->

    <div class="card mb-3 shadow shadow-sm">
      <div class="card-header"><img src="/assets/images/icon-reports.svg" class="icon-24" alt="icon"> Reports</div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <router-link to="/reports/basic">Visit report</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/reports/echo">Echo report</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/reports" class="">All reports</router-link>
        </li>
      </ul>
    </div><!-- card -->

    <div class="card mb-3 shadow shadow-sm">
      <div class="card-header"><img src="/assets/images/icon-diagnoses.svg" class="icon-24" alt="icon"> Diagnoses</div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <router-link to="/diagnoses#visit-symptoms" class="">Clinical details</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/diagnoses#visit-diff-diagnoses" class="">Differential diagnoses</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/diagnoses#visit-investigation" class="">Investigations</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/diagnoses#visit-diagnoses" class="">Diagnoses</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/diagnoses#visit-problems" class="">Problems list</router-link>
        </li>
      </ul>
    </div><!-- card -->


    <div class="card mb-3 shadow shadow-sm">
      <div class="card-header"><img src="/assets/images/icon-special-investigations.svg" class="icon-24" alt="icon">
        Investigations
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <router-link to="/special/ecg" class="">Electrocardiogram</router-link>
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
      <div class="card-header"><img src="/assets/images/icon-interventions.svg" class="icon-24" alt="icon">
        Interventions
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <router-link to="/prescriptions" class="text-danger font-weight-bold">Prescriptions</router-link>
        </li>

        <li class="list-group-item">
          <router-link to="/referral-letters" class="">Referral letter</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/further-investigations" class="">Further investigations</router-link>
        </li>

        <li class="list-group-item">
          <router-link to="/other-remarks" class="">Other remarks</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/review-in" class="">Review</router-link>
        </li>
      </ul>
    </div><!-- card -->


  </div>

</template>

<script>
export default {
  name: "SidebarGroup"
}
</script>

<style scoped>

</style>
