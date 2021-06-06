<template>

  <div>

    <div class="row">
      <div class="col">
        <h3 class="text-center">Special Investigations</h3>
      </div>
    </div>

    <div class="row">
      <div class="col">

        <div id="section-visit-ecg">
          <div class="card shadow shadow-sm">

            <div class="card-header">
              Coronary CT
            </div>

            <div class="card-body">
              <VisitCoronaryCT/>
            </div>
          </div><!-- card -->
        </div><!-- visit ecg -->

      </div>
    </div>

  </div><!-- template -->

</template>

<script>
import VisitCoronaryCT from "../../components/special_investigations/VisitCoronaryCT";
export default {
  name: "VisitCoronaryCTView",
  components: {VisitCoronaryCT}
}
</script>

<style scoped>

</style>
