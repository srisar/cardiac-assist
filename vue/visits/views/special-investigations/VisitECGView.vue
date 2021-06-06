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
              Electrocardiogram (ECG)
            </div>

            <div class="card-body">
              <VisitECG/>
            </div>
          </div><!-- card -->
        </div><!-- visit ecg -->

      </div>
    </div>

  </div><!-- template -->

</template>

<script>
import VisitECG from "../../components/special_investigations/VisitECG";

export default {
  name: "VisitECGView",
  components: {VisitECG}
}
</script>

<style scoped>

</style>
