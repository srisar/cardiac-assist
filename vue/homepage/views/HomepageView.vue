<template>

  <div>

    <div class="container-fluid">
      <div class="row">
        <div class="col text-right">

          <h3>Dr Arulnithy's Cardiac Clinic System</h3>

        </div>
      </div>
    </div>
    <!-- title area -->

    <PatientsSection/>

    <hr>

    <CommonStatsSection/>


    <!-- Management -->
    <div class="container my-3">

      <div class="row">
        <div class="col">
          <h3 class="text-uppercase text-center">Management</h3>
        </div>
      </div>

      <div class="row my-4">

        <div class="col">
          <div class="card shadow shadow-sm">
            <div class="card-body text-center">
              <a href="/app/symptoms/manage.php">
                <div>
                  <img src="assets/images/icon-symptoms.svg" alt="" class="icon">
                </div>
                <div>Symptoms</div>
              </a>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card shadow shadow-sm">
            <div class="card-body text-center">
              <a href="/app/diseases/manage.php">
                <div>
                  <img src="assets/images/icon-diseases.svg" alt="" class="icon">
                </div>
                <div>Diseases</div>
              </a>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card shadow shadow-sm">
            <div class="card-body text-center">

              <a href="/app/investigations/manage.php">
                <div>
                  <img src="assets/images/icon-investigations.svg" alt="" class="icon">
                </div>
                <div>Investigations</div>
              </a>

            </div>
          </div>
        </div>


        <div class="col">
          <div class="card shadow shadow-sm">
            <div class="card-body text-center">

              <a href="/app/drugs/manage.php">
                <div>
                  <img src="assets/images/icon-drugs.svg" alt="" class="icon">
                </div>
                <div>Drugs</div>
              </a>

            </div>
          </div>
        </div>

      </div><!-- row -->

      <div class="row my-4 justify-content-center">
        <div class="col-3">
          <div class="card shadow shadow-sm">
            <div class="card-body text-center">

              <a href="/app/echo/remarks.php">
                <div>
                  <img src="assets/images/icon-remarks.svg" alt="" class="icon">
                </div>
                <div>Echo Remarks</div>
              </a>

            </div>
          </div>
        </div><!-- col -->

        <div class="col-3">
          <div class="card shadow shadow-sm">
            <div class="card-body text-center">

              <a href="/app/referral-letters/manage.php">
                <div>
                  <img src="assets/images/icon-letters.svg" alt="" class="icon">
                </div>
                <div>Referral letter models</div>
              </a>

            </div>
          </div>
        </div><!-- col -->

      </div>

    </div>

  </div><!-- template -->


</template>

<script>
import CommonStatsSection from '@/homepage/views/stats/CommonStatsSection.vue';
import PatientsSection from './PatientsSection';

export default {
  name: 'HomepageView',
  components: { CommonStatsSection, PatientsSection },
};
</script>

<style scoped>

.icon {
  width: 64px;
}

</style>
